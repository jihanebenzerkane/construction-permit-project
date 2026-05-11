<?php

use App\Http\Controllers\Api\AuthTokenController;
use App\Http\Controllers\Api\PermitApiController;
use App\Http\Controllers\Api\PermitWorkflowApiController;
use App\Http\Controllers\Api\StatusApiController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/token', [AuthTokenController::class, 'store'])->name('api.auth.token');

Route::middleware('auth.api')->group(function () {
    Route::delete('/auth/token', [AuthTokenController::class, 'destroy'])->name('api.auth.token.destroy');
    Route::get('/auth/me', [AuthTokenController::class, 'me'])->name('api.auth.me');

    Route::get('/statuses', [StatusApiController::class, 'index'])->name('api.statuses.index');

    Route::get('/permits', [PermitApiController::class, 'index'])->name('api.permits.index');
    Route::get('/permits/{id}', [PermitApiController::class, 'show'])->name('api.permits.show');

    Route::middleware('role:agent_urbanisme')->group(function () {
        Route::post('/permits/{id}/validate', [PermitWorkflowApiController::class, 'validatePermit'])->name('api.permits.validate');
        Route::post('/permits/{id}/reject', [PermitWorkflowApiController::class, 'reject'])->name('api.permits.reject');
        Route::post('/permits/{id}/request-docs', [PermitWorkflowApiController::class, 'requestDocs'])->name('api.permits.request-docs');
    });

    Route::middleware('role:administrateur')->prefix('admin')->group(function () {
        Route::apiResource('roles', RoleController::class);
        Route::post('roles/{role}/permissions', [RoleController::class, 'syncPermissions'])->name('api.admin.roles.permissions.sync');
        Route::apiResource('permissions', PermissionController::class);
    });
});
