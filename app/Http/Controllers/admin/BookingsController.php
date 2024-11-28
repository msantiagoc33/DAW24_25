<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Platform;
use App\Models\Apartment;
use Illuminate\Contracts\View\View;

use function Pest\Laravel\delete;

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
        $clientes = Client::orderBy('name')->get();
        $plataformas = Platform::all();
        $apartamentos = Apartment::all();

        return view('admin.bookings.create', compact('clientes', 'plataformas', 'apartamentos'));
    }

    /**
     * Almacenar una nueva reserva
     */
    public function store(Request $request)
    {

        $request->validate([
            'fechaEntrada' => 'required',
            'fechaSalida' => 'required',
            'huespedes' => 'required',
            'importe' => 'required',
            'comentario' => 'nullable',
            'platform_id' => 'required',
            'client_id' => 'required',
            'apartment_id' => 'required',
        ]);

        // Crear la reserva
        $reserva = new Booking();
        $reserva->fechaEntrada = $request->fechaEntrada;
        $reserva->fechaSalida = $request->fechaSalida;
        $reserva->huespedes = $request->huespedes;
        $reserva->importe = $request->importe;
        $reserva->comentario = $request->comentario;
        $reserva->platform_id = $request->platform_id;
        $reserva->client_id = $request->client_id;
        $reserva->apartment_id = $request->apartment_id;
        $reserva->user_id = auth()->id(); // Asignar el usuario conectado
        $reserva->save();

        return redirect()->route('admin.bookings.index')->with('success', 'Reserva creada con éxito.');
    }

    /**
     * Mostar una reserva
     */
    public function show(Booking $booking)
    {
        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Mostar el formulario para editar una reserva
     */
    public function edit(Booking $booking): View
    {
        $clientes = Client::all();
        $plataformas = Platform::all();
        $apartamentos = Apartment::all(); 

        return view('admin.bookings.edit', compact('booking', 'clientes', 'plataformas', 'apartamentos'));
    }

    /**
     * Actualizar una reserva
     */
    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'fechaEntrada' => 'required',
            'fechaSalida' => 'required',
            'huespedes' => 'required',
            'importe' => 'required',
            'comentario' => 'nullable',
            'platform_id' => 'required',
            'client_id' => 'required',
            'apartment_id' => 'required',
        ]);

        $booking->fechaEntrada = $request->fechaEntrada;
        $booking->fechaSalida = $request->fechaSalida;
        $booking->huespedes = $request->huespedes;
        $booking->importe = $request->importe;
        $booking->comentario = $request->comentario;
        $booking->platform_id = $request->platform_id;
        $booking->client_id = $request->client_id;
        $booking->apartment_id = $request->apartment_id;
        $booking->user_id = auth()->id(); // Asignar el usuario conectado
        $booking->save();

        return redirect()->route('admin.bookings.index')->with('success', 'Reserva actualizada con éxito.');
    }

    /**
     * Eliminar una reserva
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('admin.bookings.index')->with('success', 'Reserva eliminada con éxito.');
    }
}
