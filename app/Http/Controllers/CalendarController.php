<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class CalendarController extends Controller
{
    public function index()
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
