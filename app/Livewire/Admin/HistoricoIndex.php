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
     * Define los parámetros que serán incluidos en la URL como parte de la cadena de consulta.
     * Esto permite que el estado de la búsqueda y el valor de "porPágina" se mantengan en la URL, 
     * y sean accesibles cuando se recargue la página o se compartan enlaces.
     *
     * @var array $queryString
     * 
     * @property string $search Parámetro de búsqueda que se incluye en la URL. Si no se proporciona, se usa una cadena vacía por defecto.
     * @property int $porPagina Número de elementos por página en la paginación. El valor por defecto es 5.
     */
    protected $queryString = [
        'search' => ['except' => ''],
        'porPagina' => ['except' => '5'],
    ];

    /**
     * Propiedad para almacenar la cadena de búsqueda.
     * 
     * @var string
     */
    public $search = '';

    /**
     * Propiedad para almacenar el número de elementos por página.
     * 
     * @var string
     */
    public $porPagina = '5';

    /**
     * Propiedad para almacenar el número de página actual.
     * 
     * @var int
     */
    public $page = 1;

    /**
     * Método para limpiar los filtros de búsqueda y la paginación a 5.
     * 
     * Este método se ejecuta al pulsar el botón "X" del formulario de búsqueda.
     * 
     * @return void
     */
    public function clear()
    {
        $this->search = '';
        $this->porPagina = '5';
        $this->page = 1;
        $this->selectedApartment = $this->apartamentos->first()->id ?? null; // Reestablece al primer apartamento disponible
    }

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

        // *************************************************************************
        // Listar las reservas históricas del apartamento seleccionado más los filtros de búsqueda
        $reservas = Booking::where('historico', true)
            ->where('apartment_id',  $this->selectedApartment)
            ->where(function ($query) {
                // Buscar por fecha de entrada, fecha de salida o nombre del cliente
                if ($this->search) {
                    $query->where('fechaEntrada', 'like', '%' . $this->search . '%')
                        ->orWhere('fechaSalida', 'like', '%' . $this->search . '%')
                        ->orWhereHas('client', function ($query) {
                            $query->where('name', 'like', '%' . $this->search . '%');
                        });
                }
            })
            ->orderBy('fechaEntrada', 'asc')
            ->paginate($this->porPagina);

        // ****************************************************
        // Calcular el importe total de las reservas históricas del apartamento seleccionado más los filtros de búsqueda
        $totalImporte = Booking::where('historico', true)
            ->where('apartment_id',  $this->selectedApartment)

            ->where(function ($query) {
                // Buscar por fecha de entrada, fecha de salida o nombre del cliente
                if ($this->search) {
                    $query->where('fechaEntrada', 'like', '%' . $this->search . '%')
                        ->orWhere('fechaSalida', 'like', '%' . $this->search . '%')
                        ->orWhereHas('client', function ($query) {
                            $query->where('name', 'like', '%' . $this->search . '%');
                        });
                }
            })
            ->sum('importe');

        // ****************************************************

        // Renderizar la vista con los datos obtenidos
        return view('livewire.admin.historico-index', compact('reservas', 'totalImporte'));
    }
}
