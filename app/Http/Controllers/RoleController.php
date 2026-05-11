<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoleController extends Controller
{
    public function index(Request $request): JsonResponse|View
    {
        $roles = Role::query()->with('permissions')->orderBy('nom')->get();

        if ($this->jsonResponse($request)) {
            return response()->json($roles);
        }

        return view('admin.roles.index', compact('roles'));
    }

    public function create(Request $request): View
    {
        return view('admin.roles.create');
    }

    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $data = $request->validate([
            'nom' => 'required|string|max:100|unique:roles,nom',
        ]);

        $role = Role::query()->create($data);

        if ($this->jsonResponse($request)) {
            return response()->json($role->load('permissions'), 201);
        }

        return redirect()->route('admin.roles.index')
            ->with('success', 'Rôle créé.');
    }

    public function show(Request $request, Role $role): JsonResponse|RedirectResponse
    {
        if ($this->jsonResponse($request)) {
            return response()->json($role->load('permissions'));
        }

        return redirect()->route('admin.roles.edit', $role);
    }

    public function edit(Request $request, Role $role): View
    {
        $permissions = Permission::query()->orderBy('nom')->get();

        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role): JsonResponse|RedirectResponse
    {
        $data = $request->validate([
            'nom' => 'required|string|max:100|unique:roles,nom,'.$role->id,
        ]);

        $role->update($data);

        if ($this->jsonResponse($request)) {
            return response()->json($role->fresh()->load('permissions'));
        }

        return redirect()->route('admin.roles.index')
            ->with('success', 'Rôle mis à jour.');
    }

    public function destroy(Request $request, Role $role): JsonResponse|RedirectResponse
    {
        if ($role->users()->exists()) {
            if ($this->jsonResponse($request)) {
                return response()->json(['message' => 'Impossible de supprimer : des utilisateurs ont ce rôle.'], 422);
            }

            return back()->withErrors(['role' => 'Des utilisateurs ont encore ce rôle.']);
        }

        $role->permissions()->detach();
        $role->delete();

        if ($this->jsonResponse($request)) {
            return response()->json(['message' => 'Rôle supprimé.']);
        }

        return redirect()->route('admin.roles.index')
            ->with('success', 'Rôle supprimé.');
    }

    public function syncPermissions(Request $request, Role $role): JsonResponse|RedirectResponse
    {
        $request->validate([
            'permission_ids' => 'nullable|array',
            'permission_ids.*' => 'integer|exists:permissions,id',
        ]);

        $role->permissions()->sync($request->input('permission_ids', []));

        if ($this->jsonResponse($request)) {
            return response()->json($role->fresh()->load('permissions'));
        }

        return redirect()->route('admin.roles.edit', $role)
            ->with('success', 'Permissions mises à jour.');
    }

    private function jsonResponse(Request $request): bool
    {
        return $request->wantsJson() || $request->is('api/*');
    }
}
