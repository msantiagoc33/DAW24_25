<?php

namespace App\Livewire\Admin;

use App\Models\Apartment;
use App\Models\Booking;
use App\Models\Factura;

use Livewire\Component;
use Carbon\Carbon;

class Fiscalidad extends Component
{

    public $apartamentos;
    public $year; // Propiedad pública para enlazar con el input
    public $apartment_id; // Apartamento seleccionado
    public $reservasAnnio; // Reservas del año seleccionado
    public $totalFacturas; // Total de facturas del año seleccionado
    public $totalDias; // Total de días ocupados del año seleccionado
    public $totalHistorico; // Importe Total de los días ocupados del año seleccionado
    public $nombreApartamento; // Nombre del apartamento seleccionado

    public function mount()
    {
        $this->apartamentos = Apartment::all();
    }


    public function calculoTotales()
    {

        // Validación de los datos de entrada antes de realizar las consultas
        $this->validate([
            'year' => 'required|integer|min:2000|max:' . date('Y'),
            'apartment_id' => 'required|exists:apartments,id',
        ]);

        $this->nombreApartamento = Apartment::find($this->apartment_id)->name;

        $desde = Carbon::createFromDate($this->year, 1, 1);
        $hasta = Carbon::createFromDate($this->year, 12, 31);

        $desde = $desde->toDateString();
        $hasta = $hasta->toDateString();

        $this->reservasAnnio = Booking::whereBetween('fechaSalida', [$desde, $hasta])
            ->where('apartment_id', '=', $this->apartment_id)
            ->where('historico', '=', true)
            ->get();

        $this->totalHistorico = Booking::whereBetween('fechaSalida', [$desde, $hasta])
            ->where('apartment_id', '=', $this->apartment_id)
            ->where('historico', '=', true)
            ->sum('importe') ?: 0;

        $this->totalFacturas = Factura::whereBetween('fecha', [$desde, $hasta])
            ->where('apartment_id', $this->apartment_id)
            ->sum('importe') ?: 0;

        $this->totalDias = Booking::whereBetween('fechaSalida', [$desde, $hasta])
            ->where('apartment_id', $this->apartment_id)
            ->selectRaw('SUM(DATEDIFF(fechaSalida, fechaEntrada)) as total_dias')
            ->value('total_dias');

    }

    public function render()
    {
        
        return view('livewire.admin.fiscalidad');
    }
}
