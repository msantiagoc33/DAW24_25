<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\PermisoController;

Route::get('/', [UserController::class, 'menu'])->middleware(['auth', 'verified'])->name('menu');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('roles/index', [RoleController::class, 'index'])->name('roles.index');
    Route::get('roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('roles/store', [RoleController::class, 'store'])->name('roles.store');
    Route::get('roles/{rol}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('roles/{rol}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('roles/{rol}', [RoleController::class, 'destroy'])->name('roles.destroy');
    Route::get('roles/rolesAsignados', [RoleController::class, 'rolesAsignados'])->name('roles.rolesAsignados');  
    Route::post('roles/storeRoleToUser', [RoleController::class, 'storeRoleToUser'])->name('roles.storeRoleToUser');
    Route::get('roles/asignarRoleToUser', [RoleController::class, 'asignarRoleToUser'])->name('roles.asignarRoleToUser');

    Route::get('permisos/index', [PermisoController::class, 'index'])->name('permisos.index');
    Route::get('permisos/create', [PermisoController::class, 'create'])->name('permisos.create');
    Route::post('permisos/store', [PermisoController::class, 'store'])->name('permisos.store');
});

require __DIR__.'/auth.php'; 
