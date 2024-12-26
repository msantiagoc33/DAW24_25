<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

use App\Models\Apartment;
use App\Models\Booking;
use App\Models\Factura;

class PDFController extends Controller
{
    public function index($apartment)
    {
        // Verificar si el apartamento existe
        $apartamento = Apartment::find($apartment);
        if (!$apartamento) {
            // Si no existe, redirigir con mensaje de error
            return redirect()->route('admin.bookings.index')->with('error', 'Apartamento no encontrado.');
        }

        // Obtener las reservas para el apartamento seleccionado
        // Además de obtenemos la relación con la tabla client para cada reserva de manera anticipada.
        $reservas = Booking::with('client')
            ->where('apartment_id', $apartment)
            ->where('historico', 0)
            ->orderBy('fechaSalida')
            ->get();

        // Verificar si hay reservas
        if ($reservas->isEmpty()) {
            // Si no hay reservas, redirigir y mostrar el mensaje de información
            return redirect()->route('admin.bookings.index')->with('info', 'No hay reservas para este apartamento.');
        }

        // Generar el PDF con las reservas
        $pdf = Pdf::setPaper('a4')->loadView('admin.pdfs.reservas', [
            'reservas' => $reservas,
            'apartamento' => $apartamento
        ]);

        // Mostrar el PDF en el navegador
        return $pdf->stream('reservas_' . $apartamento->name . '.pdf');
    }
}
