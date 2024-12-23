<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Client;
use Livewire\WithPagination;
use App\Livewire\helpers\variablesParaBusquedas;

/**
 * Componente Livewire para gestionar el índice de clientes.
 *
 * Este componente permite listar y paginar los clientes registrados en el sistema.
 */
class ClientsIndex extends Component
{
    use WithPagination;

    /**
     * Se define el tema de paginación a utilizar.
     *
     * @var string
     */
    protected $paginationTheme = 'bootstrap';

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
    }

    /**
     * Se define la vista que se va a renderizar.
     * 
     * Este método se encarga de renderizar la vista de listado de clientes
     * ordenados por id de forma descendente y paginados de 12 en 12.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        // Se obtienen los clientes ordenados por id de forma descendente y paginados de 12 en 12.
        // $clients = Client::orderBy('id', 'desc')->paginate(12);
        // Obtener las reservas activas asociadas al apartamento seleccionado y filtradas por nombre de cliente si se ha introducido una búsqueda
        // $reservas = Client::where('historico', false)
        //     ->where('apartment_id',  $this->selectedApartment)

        //     ->where(function ($query) {
        //         // Buscar por fecha de entrada, fecha de salida o nombre del cliente
        //         if ($this->search) {
        //             $query->where('fechaEntrada', 'like', '%' . $this->search . '%')
        //                 ->orWhere('fechaSalida', 'like', '%' . $this->search . '%')
        //                 ->orWhereHas('client', function ($query) {
        //                     $query->where('name', 'like', '%' . $this->search . '%');
        //                 });
        //         }
        //     })
        //     ->orderBy('id', 'desc')
        //     ->paginate($this->porPagina);

            $clients =Client::where('phone', 'like', '%' . $this->search . '%')
            ->orWhere('calle_numero', 'like', '%' .$this->search . '%')
            ->orWhere('ciudad', 'like', '%' . $this->search . '%')
            ->orWhere('provincia', 'like', '%' . $this->search . '%')
            ->orWhere('cp', 'like', '%' . $this->search . '%')
            ->orWhere('passport', 'like', '%' . $this->search . '%')
            ->orWhere('name', 'like', '%' . $this->search . '%')
            ->orWhereHas('pais', function ($query) {$query->where('nombre', 'like', '%' . $this->search . '%');})
            ->orderBy('id', 'desc')
            ->paginate($this->porPagina);

        // Se retorna la vista de listado de clientes.
        return view('livewire.admin.clients-index', compact('clients'));
    }
}
