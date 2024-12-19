<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Booking;
use App\Models\Apartment;

use Livewire\WithPagination;

/**
 * Componente Livewire para la gestión del histórico de reservas
 * 
 * Este componente permite:
 * - Listar las reservas históricas de un apartamento
 * - Calcular el importe total de las reservas históricas
 * - Marcar como históricas las reservas que ya han pasado
 * - Paginar las reservas históricas
 * - Filtrar las reservas históricas por apartamento
 * - Mostrar el nombre del apartamento seleccionado
 */
class HistoricoIndex extends Component
{
    use WithPagination;

    /**
     * Tema de paginación de Bootstrap
     */
    protected $paginationTheme = 'bootstrap';

    /**
     * Fecha de hoy.
     * 
     * @var Carbon
     */
    public $hoy;

    /**
     * Listado de apartamentos.
     * 
     * @var Collection
     */
    public $apartamentos;

    /**
     * ID del apartamento seleccionado.
     * 
     * @var int
     */
    public $selectedApartment;

    /**
     * Nombre del apartamento seleccionado.
     * 
     * @var string
     */
    public $nombreApartamento;


    /**
     * Método que se ejecuta al inicializar el componente
     * 
     * - Cargar los apartamentos
     * - Seleccionar el primer apartamento y obtener su nombre
     * - Marcar como históricas las reservas que ya han pasado
     * 
     * @return void
     */
    public function mount()
    {
        // Cargar los apartamentos
        $this->apartamentos = Apartment::all();

        // Seleccionar el primer apartamento y obtener su nombre
        $this->selectedApartment = $this->apartamentos->first()->id;
        $this->nombreApartamento = $this->apartamentos->first()->name;

        // Fecha de hoy
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
     * Renderiza el componente
     * 
     * - Obtener el nombre del apartamento seleccionado
     * - Listar las reservas históricas del apartamento seleccionado
     * - Calcular el importe total de las reservas históricas
     * 
     * @return View
     */
    public function render()
    {
        // Obtener el nombre del apartamento seleccionado
        $this->nombreApartamento = Apartment::find($this->selectedApartment)->name;

        // Listar las reservas históricas del apartamento seleccionado
        $reservas = Booking::where('historico', true)
            ->where('apartment_id',  $this->selectedApartment)
            ->orderBy('fechaEntrada', 'asc')
            ->paginate(12);

        // Calcular el importe total de las reservas históricas
        $totalImporte = Booking::where('historico', true)
            ->where('apartment_id', $this->selectedApartment)
            ->sum('importe');

        // Renderizar la vista con los datos obtenidos
        return view('livewire.admin.historico-index', compact('reservas', 'totalImporte'));
    }
}
