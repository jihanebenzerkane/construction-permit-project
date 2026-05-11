<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PermitController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TechnicalReviewController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('welcome'));

// ====================== AUTH ======================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// ====================== CITOYEN ======================
Route::middleware(['auth', 'role:citoyen'])->group(function () {
    Route::get('/citizen/dashboard', [DashboardController::class, 'citizen'])->name('citizen.dashboard');
    Route::get('/citizen/permits', [PermitController::class, 'citizenIndex'])->name('citizen.permits');
    Route::get('/citizen/permits/create', [PermitController::class, 'create'])->name('citizen.permits.create');
    Route::post('/citizen/permits', [PermitController::class, 'store'])->name('citizen.permits.store');
    Route::get('/citizen/permits/{id}', [PermitController::class, 'show'])->name('citizen.permits.show');
});

// ====================== ARCHITECTE ======================
Route::middleware(['auth', 'role:architecte'])->group(function () {
    Route::get('/architect/dashboard', [DashboardController::class, 'architect'])->name('architect.dashboard');
    Route::get('/architect/permits', [PermitController::class, 'architectIndex'])->name('architect.permits');
});

// ====================== AGENT URBANISME ======================
Route::middleware(['auth', 'role:agent_urbanisme'])->group(function () {
    Route::get('/agent/dashboard', [DashboardController::class, 'agent'])->name('agent.dashboard');
    Route::get('/agent/permits', [PermitController::class, 'agentIndex'])->name('agent.permits');
    Route::post('/agent/permits/{id}/validate', [PermitController::class, 'validatePermit']);
    Route::post('/agent/permits/{id}/reject', [PermitController::class, 'rejectPermit']);
    Route::post('/agent/permits/{id}/request-docs', [PermitController::class, 'requestDocs']);
});

// ====================== SERVICE TECHNIQUE ======================
Route::middleware(['auth', 'role:service_technique'])->group(function () {
    Route::get('/technical/dashboard', [DashboardController::class, 'technical'])->name('technical.dashboard');
    Route::get('/technical/permits', [PermitController::class, 'technicalIndex'])->name('technical.permits');
    Route::post('/technical/permits/{id}/review', [TechnicalReviewController::class, 'store']);
});

// ====================== ADMIN ======================
Route::middleware(['auth', 'role:administrateur'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::post('/admin/users/{id}/role', [AdminController::class, 'updateRole']);
    Route::get('/admin/statistics', [AdminController::class, 'statistics'])->name('admin.statistics');
    Route::get('/admin/archives', [ArchiveController::class, 'index'])->name('admin.archives');

    Route::get('/admin/roles', [RoleController::class, 'index'])->name('admin.roles.index');
    Route::get('/admin/roles/create', [RoleController::class, 'create'])->name('admin.roles.create');
    Route::post('/admin/roles', [RoleController::class, 'store'])->name('admin.roles.store');
    Route::get('/admin/roles/{role}/edit', [RoleController::class, 'edit'])->name('admin.roles.edit');
    Route::put('/admin/roles/{role}', [RoleController::class, 'update'])->name('admin.roles.update');
    Route::patch('/admin/roles/{role}', [RoleController::class, 'update']);
    Route::delete('/admin/roles/{role}', [RoleController::class, 'destroy'])->name('admin.roles.destroy');
    Route::post('/admin/roles/{role}/permissions', [RoleController::class, 'syncPermissions'])->name('admin.roles.permissions.sync');

    Route::get('/admin/permissions', [PermissionController::class, 'index'])->name('admin.permissions.index');
    Route::get('/admin/permissions/create', [PermissionController::class, 'create'])->name('admin.permissions.create');
    Route::post('/admin/permissions', [PermissionController::class, 'store'])->name('admin.permissions.store');
    Route::get('/admin/permissions/{permission}/edit', [PermissionController::class, 'edit'])->name('admin.permissions.edit');
    Route::put('/admin/permissions/{permission}', [PermissionController::class, 'update'])->name('admin.permissions.update');
    Route::patch('/admin/permissions/{permission}', [PermissionController::class, 'update']);
    Route::delete('/admin/permissions/{permission}', [PermissionController::class, 'destroy'])->name('admin.permissions.destroy');
});

// ====================== SHARED ======================
Route::middleware('auth')->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markRead']);
    Route::post('/permits/{id}/documents', [DocumentController::class, 'upload']);
});
