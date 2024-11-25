<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Country;
use Illuminate\Contracts\View\View;

class BookingsController extends Controller
{
    /**
     * Listado de reservas
     */
    public function index(): View
    {
        return view('admin.bookings.index');
    }

    /**
     * Crear una nueva reserva
     */
    public function create(): View
    {
        return view('admin.bookings.create', [
            'clients' => Client::all(),
            'countries' => Country::all(),
        ]);
    }

    /**
     * Almacenar una nueva reserva
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Mostar una reserva
     */
    public function show(Booking $booking)
    {
        //
    }

    /**
     * Mostar el formulario para editar una reserva
     */
    public function edit(Booking $booking): View
    {
        return view('admin.bookings.edit', [
            'booking' => $booking,
            'clients' => Client::all(),
            'countries' => Country::all(),
        ]);
    }

    /**
     * Actualizar una reserva
     */
    public function update(Request $request, Booking $booking)
    {
        //
    }

    /**
     * Eliminar una reserva
     */
    public function destroy(Booking $booking)
    {
        //
    }
}
