<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Booking;
use App\Models\Apartment;

use Livewire\WithPagination;

/**
 * Componente Livewire para gestionar el índice de reservas.
 *
 * Este componente permite visualizar, filtrar y actualizar reservas asociadas a apartamentos.
 */
class BookingsIndex extends Component
{
    use WithPagination;

    /**
     * Tema de paginación de Bootstrap.
     * 
     * @var string
     */
    protected $paginationTheme = 'bootstrap';

    /**
     * Propiedad para almacenar el índice de reservas.
     * 
     * @var int
     */
    public $indiceReservas = 0;

    /**
     * Propiedad para almacenar la fecha actual.
     * 
     * @var \Illuminate\Support\Carbon
     */
    public $hoy;

    /**
     * Propiedad para almacenar la lista de apartamentos.
     * 
     * @var \Illuminate\Database\Eloquent\Collection
     */
    public $apartamentos;

    /**
     * Propiedad para almacenar el apartamento seleccionado.
     * 
     * @var int
     */
    public $selectedApartment;

    /**
     * Obtenemos el nombre del apartamento seleccionado.
     * @var string
     */
    public $nombreApartamento;

    /**
     * Método de inicialización del componente.
     * Se ejecuta al montar el componente y realiza las siguientes acciones:
     * - Obtiene la lista de apartamentos.
     * - Selecciona el primer apartamento de la lista.
     * - Actualiza las reservas históricas basándose en la fecha de salida y la fecha actual.
     * 
     * @return void
     */
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

    
    /**
     * Método para renderizar la vista del componente.
     * 
     * Este método obtiene las reservas activas y calula el importe total de las mismas.
     * Asociada al apartamento seleccionado.
     * 
     * @return \Illuminate\View\View
     */
    public function render()
    {
        // Obtener el nombre del apartamento seleccionado
        $this->nombreApartamento = Apartment::find($this->selectedApartment)->name;

        // Obtener las reservas activas asociadas al apartamento seleccionado
        $reservas = Booking::where('historico', false)
            ->where('apartment_id',  $this->selectedApartment)
            ->orderBy('fechaEntrada', 'asc')
            ->paginate(12);

        // Calcular el importe total de las reservas activas
        $totalImporte = Booking::where('historico', false)
            ->where('apartment_id', $this->selectedApartment)
            ->sum('importe');


        return view('livewire.admin.bookings-index', compact('reservas', 'totalImporte'));
    }
}
