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
     * Método para limpiar los filtros de búsqueda.
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
        // Al cargar el componente, seleccionamos el primer apartamento de la lista
        $this->apartamentos = Apartment::all();
        $this->selectedApartment = $this->apartamentos->first()->id;
        $this->nombreApartamento = $this->apartamentos->first()->name;

        // Obtenemos la fecha actual
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
    public function updatedSelectedApartment()
    {
        // Aquí puedes hacer cualquier acción que dependa del cambio de apartamento
        // Por ejemplo, actualizar las reservas para el apartamento seleccionado.
        $this->nombreApartamento = Apartment::find($this->selectedApartment)->name;
    }

    /**
     * Método para renderizar la vista del componente.
     * 
     * Este método obtiene las reservas activas y calula el importe total de las mismas por apartamento.
     * 
     * @return \Illuminate\View\View
     */
    public function render()
    {
        // Obtener el nombre del apartamento seleccionado
        $this->nombreApartamento = Apartment::find($this->selectedApartment)->name;

        // *************************************************************************
        // Obtener las reservas activas asociadas al apartamento seleccionado y filtradas por nombre de cliente si se ha introducido una búsqueda           
        $reservas = Booking::where('historico', false)
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

        // *************************************************************************

        // Calcular el importe total de las reservas activas
        $totalImporte = Booking::where('historico', false)
            ->where('apartment_id', $this->selectedApartment)
            ->sum('importe');

        // *************************************************************************
        return view('livewire.admin.bookings-index', compact('reservas', 'totalImporte'));
    }
}
