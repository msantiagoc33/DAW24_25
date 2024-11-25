<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ApartmentsController;
use App\Http\Controllers\Admin\ConceptsController;
use App\Http\Controllers\Admin\PlatformsController;
use App\Http\Controllers\Admin\FacturasController;
use App\Http\Controllers\Admin\ClientsController;
use App\Http\Controllers\Admin\BookingsController;

// Route::get('/', [HomeController::class, 'index'])->name('admin.home');
Route::get('', [UserController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () { 
    
    Route::resource('users', UserController::class)->names('admin.users');
    Route::resource('apartments', ApartmentsController::class)->names('admin.apartments');
    Route::resource('platforms', PlatformsController::class)->names('admin.platforms');
    Route::resource('concepts', ConceptsController::class)->names('admin.concepts'); 
    Route::resource('facturas', FacturasController::class)->names('admin.facturas');    
    Route::get('facturas.busqueda', [FacturasController::class, 'busqueda'])->name('admin.facturas.busqueda');
    Route::resource('clients', ClientsController::class)->names('admin.clients');  
    Route::resource('bookings', BookingsController::class)->names('admin.bookings');

});