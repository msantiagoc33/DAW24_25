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

    public $desde;
    public $hasta;
    public $texto;
    public $importe_desde;
    public $importe_hasta;
    public $apartamento;
    public $facturas;
    public $apartment_id;

    public $apartamentos = []; // Todos los apartamentos
    public $apartamentoSeleccionado;  // ID del apartamento seleccionado

    public $totalImporte = 0; // Variable para la suma total

    // Función para restablecer los filtros después de haber hecho una búsqueda
    // Y cargar las facturas del primer apartamento
    public function resetFilters()
    {
        // Restablecer los filtros
        $this->desde = null;
        $this->hasta = null;
        $this->importe_desde = null;
        $this->importe_hasta = null;
        $this->texto = null;

        // Volver al primer apartamento y cargar sus facturas
        $primerApartamento = Apartment::first();

        if ($primerApartamento) {
            $this->apartamentoSeleccionado = $primerApartamento->id;
            $this->apartamento = $primerApartamento;

            // Cargar las facturas del primer apartamento
            $this->facturas = Factura::where('apartment_id', $primerApartamento->id)->get();
        } else {
            $this->facturas = collect(); // Si no hay apartamentos, colección vacía
        }

        // Resetea a la página 1 si estás usando paginación
        $this->resetPage();
    }


    public function mount()
    {
        // Cargar todos los apartamentos
        $this->apartamentos = Apartment::all();

        // Seleccionar el primer apartamento por defecto para mostrar sus facturas automáticamente
        $primerApartamento = Apartment::first();
        $this->apartamento = $primerApartamento;

        // Esto asegura que $facturas siempre sea un objeto iterable, incluso si no se han cargado datos.
        if ($primerApartamento) {
            $this->apartamentoSeleccionado = $primerApartamento->id;
            $this->apartamento = $primerApartamento;

            // Cargar las facturas del primer apartamento
            $this->facturas = Factura::where('apartment_id', $primerApartamento->id)->get();
        } else {
            // Si no hay apartamentos, inicializar las facturas como una colección vacía
            $this->facturas = collect();
        }
    }

    // No es necesario llamar manualmente a updatedApartamentoSeleccionado desde render. 
    // Livewire invoca automáticamente este método cuando la propiedad $apartamentoSeleccionado cambia. 
    // Si lo llamas manualmente, estás duplicando el trabajo y posiblemente provocando errores.
    public function updatedApartamentoSeleccionado($apartamentoId)
    {
        $this->totalImporte = 0; // Restablecer la suma total

        $this->resetPage(); // Resetea a la página 1 cuando cambia el filtro

        // Buscar el apartamento por ID, si está seleccionado
        $this->apartamento = $apartamentoId ? Apartment::find($apartamentoId) : null;
        $this->facturas = Factura::where('apartment_id', $this->apartamento->id)->get();
    }

    public function buscarFacturas()
    {
        $query = Factura::query();

        if ($this->apartamentoSeleccionado) {
            $query->where('apartment_id', $this->apartamentoSeleccionado);
        }

        if (!empty($this->texto)) {
            $query->whereHas('concepts', function ($q) {
                $q->where('name', 'LIKE', '%' . $this->texto . '%');
            });
        }

        if (!empty($this->desde)) {
            $query->where('fecha', '>=', $this->desde);
        }

        if (!empty($this->hasta)) {
            $query->where('fecha', '>=', $this->hasta);
        }

        if (!empty($this->importe_desde)) {
            $query->where('importe', '>=', $this->importe_desde);
        }

        if (!empty($this->importe_hasta)) {
            $query->where('importe', '<=', $this->importe_hasta);
        }

        // Calcular la suma total de los importes
        $this->totalImporte = $query->sum('importe');

        $this->facturas = $query->get();
    }

    public function render()
    {
        return view('livewire.admin.facturas-index');
    }
}
