<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Permit;
use App\Models\Status;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function users()
    {
        $users = User::with('role', 'district')->latest()->paginate(20);
        $roles = Role::all();
        return view('admin.users', compact('users', 'roles'));
    }

    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id'
        ]);

        $user = User::findOrFail($id);
        $user->update(['role_id' => $request->role_id]);

        return back()->with('success', 'Rôle mis à jour avec succès.');
    }

    public function statistics()
    {
        $totalUsers = User::count();
        $totalPermits = Permit::count();
        $byStatus = Status::withCount('permits')->get();
        $highRisk = Permit::where('risk_level', 'High')->count();
        $pending = Permit::whereHas('status', fn($q) => $q->where('nom', 'Soumis'))->count();

        return view('admin.statistics', compact('totalUsers', 'totalPermits', 'byStatus', 'highRisk', 'pending'));
    }
}
