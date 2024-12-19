<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Contracts\View\View;

/**
 * Class CalendarController
 * 
 * En este código se está utilizando FullCalendar como librería para mostrar el calendario. 
 * FullCalendar es una biblioteca de JavaScript ampliamente utilizada para crear calendarios 
 * interactivos que pueden mostrar eventos y otros datos de manera visual.
 * 
 * Instalamos FullCalendar con npm: npm install fullcalendar
 * 
 * Mostramos el calendario de reservas de los apartamentos que están activas, es decir, el campo histórico en false.
 * 
 * @package App\Http\Controllers
 * @version 1.0
 * @since 1.0
 * 
 */
class CalendarController extends Controller
{
    /**
     * Muestra el calendario de reservas
     * 
     * @return View Vista con el calendario de reservas
     */
    public function index(): View
    {       
        // Generar el calendario de reservas
        $reservasActivas = Booking::where('historico', false)
            ->get(['fechaEntrada', 'fechaSalida', 'apartment_id']);

        $fechasReservadas = $reservasActivas->map(function ($reservasActivas) {
            return [
                'start' => $reservasActivas->fechaEntrada->toDateString(),
                'end' => $reservasActivas->fechaSalida->addDay()->toDateString(),
                'title' => $reservasActivas->apartment->name,
            ];
        });

        return view('calendar.index', compact('fechasReservadas'));
    }
}
