<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Concept;

class ConceptsIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search;

     //  útil cuando tienes una paginación y quieres reiniciar la página a la primera cada vez que se realiza una búsqueda nueva.
     public function updatingSearch()
     {
         $this->resetPage();
     }
     
    public function render()
    {
        $conceptos = Concept::where('name', 'like', '%' . $this->search . '%')->paginate(6);

        return view('livewire.admin.concepts-index', compact('conceptos'));
    }
}


