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
use App\Http\Controllers\Admin\PDFController;
use App\Http\Controllers\CalendarController;

// Route::get('/home', [HomeController::class, 'index'])->name('admin.home');
Route::get('', [BookingsController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {

    Route::resource('users', UserController::class)->names('admin.users');

    Route::resource('apartments', ApartmentsController::class)->names('admin.apartments');

    Route::resource('platforms', PlatformsController::class)->names('admin.platforms');
    Route::resource('concepts', ConceptsController::class)->names('admin.concepts');

    Route::resource('facturas', FacturasController::class)->names('admin.facturas');
    Route::get('facturas.busqueda', [FacturasController::class, 'busqueda'])->name('admin.facturas.busqueda');

    Route::resource('clients', ClientsController::class)->names('admin.clients');

    Route::resource('bookings', BookingsController::class)->names('admin.bookings');
    Route::get('bookings.historico', [BookingsController::class, 'historico'])->name('admin.bookings.historico');
    Route::get('bookings.resumen', [BookingsController::class, 'resumen'])->name('admin.bookings.resumen');
    Route::get('bookings.fiscalidad', [BookingsController::class, 'fiscalidad'])->name('admin.bookings.fiscalidad');

    Route::get('calendar', [CalendarController::class, 'index'])->name('calendar.index');

    Route::get('pdfs/index/{selectedApartment}', [PDFController::class, 'index'])->name('pdfs.index');
});
