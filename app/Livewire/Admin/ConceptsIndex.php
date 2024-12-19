<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Concept;

/**
 *  Componente livewire para la gestión de conceptos.
 * 
 * Este componente permite listar, buscar, editar, eliminar y paginar conceptos.
 */
class ConceptsIndex extends Component
{
    use WithPagination;

    /**
     * Tema de paginación para el componente.
     * 
     * @var string
     */
    protected $paginationTheme = 'bootstrap';

    /**
     * Término de búsqueda ingresado por el usuario.
     * 
     * @var string|null
     */
    public $search;

    /**
     * Reinicia la paginación al actualizar el término de búsqueda.
     * 
     * Este método se ejecuta automáticamente cada vez que cambia el valor
     * de la propiedad `$search`. Reiniciar la página a la primera cada vez que se realiza una búsqueda nueva.
     * 
     * @return void
     */
    public function updatingSearch()
    {
        $this->resetPage();
    }

    /**
     * Renderiza la vista del componente.
     * 
     * Este método obtiene una lista paginada de conceptos que coincidan
     * con el término de búsqueda proporcionado por el usuario.
     * 
     * @return \Illuminate\View\View
     */
    public function render()
    {
        // Obtiene una lista paginada de conceptos que coincidan con el término de búsqueda.
        $conceptos = Concept::where('name', 'like', '%' . $this->search . '%')->paginate(6);

        // Renderiza la vista del componente con los conceptos obtenidos.
        return view('livewire.admin.concepts-index', compact('conceptos'));
    }
}
