<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Booking;
use App\Models\Apartment;

use Livewire\WithPagination;
use Carbon\Carbon;
use Pest\Mutate\Mutators\Logical\FalseToTrue;
use PHPUnit\TextUI\Configuration\Php;

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

        $this->hoy = Carbon::now()->toDateString();
        $reservas = Booking::orderBy('fechaEntrada', 'asc')->get();
        foreach ($reservas as $reserva) {
            if ($reserva->fechaSalida < $this->hoy) {
                $reserva->historico = true;
                $reserva->save();
            }
        }
    }

    public function updatedSelectedApartment()
    {
        // Este método se llama automáticamente al cambiar el valor de selectedApartment
        logger('Selected Apartment ID: ' . $this->selectedApartment);
    }


    public function render()
    {
        $this->nombreApartamento = Apartment::find($this->selectedApartment)->name;

        $reservas = Booking::where('historico', false)
            ->where('apartment_id',  $this->selectedApartment)
            ->orderBy('fechaEntrada', 'asc')
            ->paginate(5);

        return view('livewire.admin.bookings-index', compact('reservas'));
    }
}
