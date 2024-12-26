<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

use App\Models\Booking;
use App\Models\Client;
use App\Models\Platform;
use App\Models\Apartment;


/**
 * Controlador para gestionar las reservas.
 * 
 * @package App\Http\Controllers\Admin
 * @version 1.0
 * @since 1.0
 * @see \App\Models\Booking Modelo de reserva
 * @see \App\Models\Client Modelo de cliente
 * @see \App\Models\Platform Modelo de plataforma
 * @see \App\Models\Apartment Modelo de apartamento
 * @see \App\Http\Requests\BookingRequest Clase para validar los datos de las reservas
 * @see \Illuminate\Http\Request Clase para manejar las peticiones HTTP
 * @see \Illuminate\Contracts\View\View Clase para devolver vistas
 * @see \App\Http\Controllers\Controller Clase base de controladores de Laravel
 * @author Manuel Santiago Cabeza
 */
class BookingsController extends Controller
{
    /**
     * Listado de reservas
     * 
     * @return View Vista con el listado de reservas
     */
    public function index(): View
    {
        return view('admin.bookings.index');
    }

    /**
     * Crear una nueva reserva
     * 
     * @return View Vista con el formulario para crear una nueva reserva
     */
    public function create(): View
    {
        $clientes = Client::orderBy('id', 'desc')->get();
        $plataformas = Platform::all();
        $apartamentos = Apartment::all();

        return view('admin.bookings.create', compact('clientes', 'plataformas', 'apartamentos'));
    }

    /**
     * Almacenar una nueva reserva
     * 
     * @param Request $request Datos de la petición
     * @return RedirectResponse Redirección a la lista de reservas
     */
    public function store(BookingRequest $request)
    {
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
     * Mostar una reserva en detalle
     * 
     * @param Booking $booking Reserva a mostrar
     * @return View Vista con los detalles de la reserva
     */
    public function show(Booking $booking)
    {
        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Mostar el formulario para editar una reserva
     * 
     * @param Booking $booking Reserva a editar
     * @return View Vista con el formulario para editar la reserva
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
     * 
     * @param Request $request Datos de la petición
     * @param Booking $booking Reserva a actualizar
     * @return RedirectResponse Redirección a la lista de reservas
     */
    public function update(BookingRequest $request, Booking $booking)
    {
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
     * 
     * @param Booking $booking Reserva a eliminar
     * @return RedirectResponse Redirección a la lista de reservas
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('admin.bookings.index')->with('success', 'Reserva eliminada con éxito.');
    }

    /**
     * Listado de reservas históricas
     * 
     * @return View Vista con el listado de reservas históricas
     */
    public function historico(): View
    {
        return view('admin.bookings.historico');
    }

    /**
     * Resumen de reservas
     * 
     * @return View Vista con el resumen de reservas
     * Devuelve un listado con el total de ingresos por año y apartamento y el total de días de estancia
     */
    public function resumen(): View
    {
        $totalPorYears = Booking::selectRaw('YEAR(fechaentrada) as anio, SUM(importe) as total, apartment_id, SUM(DATEDIFF(fechasalida, fechaentrada)) as total_dias')
        ->where('historico', true)
        ->groupBy('anio','apartment_id')
        ->orderBy('apartment_id', 'ASC')
        ->get();

        return view('admin.bookings.resumen', compact('totalPorYears'));
    }

    /**
     * Informe de fiscalidad
     * 
     * @return View Vista con el informe de fiscalidad
     * Utiliza un componente de Livewire para mostrar un formulario con los filtros para generar el informe
     * Después de seleccionar el apartamento y el año, muestra un listado con el total de ingresos, el total de días de estancia 
     * y los gastos imputables por el número de días alquilado.*/
    public function fiscalidad(): View
    {
        return view('admin.bookings.fiscalidad');
    }

}
