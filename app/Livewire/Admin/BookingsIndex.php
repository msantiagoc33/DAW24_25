<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Booking;
use App\Models\Apartment;

use Livewire\WithPagination;

class BookingsIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $indiceReservas = 0;
    public $hoy;
    public $apartamentos;
    public $selectedApartment;
    public $nombreApartamento;

    public function mount()
    {
        $this->apartamentos = Apartment::all();
        $this->selectedApartment = $this->apartamentos->first()->id;
        $this->nombreApartamento = $this->apartamentos->first()->name;

        $this->hoy = now();

        // Marcar como históricas las reservas que ya han pasado
        $reservas = Booking::orderBy('fechaEntrada', 'asc')->get();
        foreach ($reservas as $reserva) {
            if ($reserva->fechaSalida < $this->hoy) {
                $reserva->historico = true;
                $reserva->save();
            }
        }
    }


    public function render()
    {
        // Obtener el nombre del apartamento seleccionado
        $this->nombreApartamento = Apartment::find($this->selectedApartment)->name;

        $reservas = Booking::where('historico', false)
            ->where('apartment_id',  $this->selectedApartment)
            ->orderBy('fechaEntrada', 'asc')
            ->paginate(12);

        $totalImporte = Booking::where('historico', false)
            ->where('apartment_id', $this->selectedApartment)
            ->sum('importe');


        return view('livewire.admin.bookings-index', compact('reservas', 'totalImporte'));
    }
}
