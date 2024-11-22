<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Factura;
use App\Models\Apartment;
use Livewire\WithPagination;

class FacturasIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $apartamentos = []; // Todos los apartamentos
    public $apartamentoSeleccionado;  // ID del apartamento seleccionado
    public $apartamento;  // Apartamento seleccionado


    public function mount()
    {
        // Cargar todos los apartamentos y facturas
        $this->apartamentos = Apartment::all();

        // Seleccionar el primer apartamento por defecto para mostrar sus facturas automáticamente
        $primerApartamento = Apartment::first();
        $this->apartamento = $primerApartamento; 
    }

    // No es necesario llamar manualmente a updatedApartamentoSeleccionado desde render. Livewire invoca automáticamente este método cuando la propiedad $apartamentoSeleccionado cambia. Si lo llamas manualmente, estás duplicando el trabajo y posiblemente provocando errores.
    public function updatedApartamentoSeleccionado($apartamentoId)
    {
        $this->resetPage(); // Resetea a la página 1 cuando cambia el filtro

        // Buscar el apartamento por ID, si está seleccionado
        $this->apartamento = $apartamentoId ? Apartment::find($apartamentoId) : null;
    }

    public function render()
    {
        $facturas = Factura::when($this->apartamentoSeleccionado, function ($query) {
            $query->where('apartment_id', $this->apartamentoSeleccionado);
        })->paginate(5);

        return view('livewire.admin.facturas-index', compact('facturas'));
    }
}
