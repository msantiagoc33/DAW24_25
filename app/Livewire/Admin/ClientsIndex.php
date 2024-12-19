<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Client;
use Livewire\WithPagination;

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
        $clients = Client::orderBy('id', 'desc')->paginate(12);

        // Se retorna la vista de listado de clientes.
        return view('livewire.admin.clients-index', compact('clients'));
    }
}
