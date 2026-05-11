<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PermissionController extends Controller
{
    public function index(Request $request): JsonResponse|View
    {
        $permissions = Permission::query()->with('roles')->orderBy('nom')->get();

        if ($this->jsonResponse($request)) {
            return response()->json($permissions);
        }

        return view('admin.permissions.index', compact('permissions'));
    }

    public function create(Request $request): View
    {
        return view('admin.permissions.create');
    }

    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $data = $request->validate([
            'nom' => 'required|string|max:150|unique:permissions,nom',
            'description' => 'nullable|string|max:2000',
        ]);

        $permission = Permission::query()->create($data);

        if ($this->jsonResponse($request)) {
            return response()->json($permission, 201);
        }

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission créée.');
    }

    public function show(Request $request, Permission $permission): JsonResponse|RedirectResponse
    {
        if ($this->jsonResponse($request)) {
            return response()->json($permission->load('roles'));
        }

        return redirect()->route('admin.permissions.edit', $permission);
    }

    public function edit(Request $request, Permission $permission): View
    {
        return view('admin.permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission): JsonResponse|RedirectResponse
    {
        $data = $request->validate([
            'nom' => 'required|string|max:150|unique:permissions,nom,'.$permission->id,
            'description' => 'nullable|string|max:2000',
        ]);

        $permission->update($data);

        if ($this->jsonResponse($request)) {
            return response()->json($permission->fresh()->load('roles'));
        }

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission mise à jour.');
    }

    public function destroy(Request $request, Permission $permission): JsonResponse|RedirectResponse
    {
        $permission->roles()->detach();
        $permission->delete();

        if ($this->jsonResponse($request)) {
            return response()->json(['message' => 'Permission supprimée.']);
        }

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission supprimée.');
    }

    private function jsonResponse(Request $request): bool
    {
        return $request->wantsJson() || $request->is('api/*');
    }
}
