<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Booking;
use Livewire\WithPagination;
use Carbon\Carbon;
use Pest\Mutate\Mutators\Logical\FalseToTrue;

class BookingsIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $indiceReservas = 0;
    public $hoy;

    public function mount()
    {
        $this->hoy = Carbon::now()->toDateString();
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
        $reservas = Booking::where('historico', false)->orderBy('fechaEntrada', 'asc')->paginate(5);
        return view('livewire.admin.bookings-index', compact('reservas'));
    }
}
