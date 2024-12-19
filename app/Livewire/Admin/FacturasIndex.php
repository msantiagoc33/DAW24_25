<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Factura;
use App\Models\Apartment;
use Livewire\WithPagination;

/**
 * Componente Livewire para la página de facturas.
 * 
 * Ese componente permite:
 * - Filtrar facturas por apartamento, texto, fecha y rango de importe.
 * - Mostrar la suma total de los importes de las facturas filtradas.
 * - Restablecer los filtros y cargar las facturas del primer apartamento.
 * - Cargar las facturas del apartamento seleccionado.
 * - Buscar facturas según los filtros aplicados.
 * 
 */
class FacturasIndex extends Component
{
    use WithPagination;

    /**
     * Define el tema de paginación de Bootstrap.
     * 
     * @var string
     */
    protected $paginationTheme = 'bootstrap';

    /**
     * Filtros de búsqueda.
     * 
     * @var string|null $desde Fecha de inicio.
     * @var string|null $hasta Fecha de fin.
     * @var string|null $texto Texto a buscar en los conceptos.
     * @var float|null $importe_desde Importe mínimo.
     * @var float|null $importe_hasta Importe máximo.
     */
    public $desde;
    public $hasta;
    public $texto;
    public $importe_desde;
    public $importe_hasta;

    /**
     * Propiedades relacionadas con los apartamentos y las facturas.
     * 
     * @var Apartment|null $apartamento Apartamento actual seleccionado.
     * @var Collection $facturas Facturas del apartamento seleccionado.
     * @var int $apartment_id ID del apartamento seleccionado.
     * @var Collection $apartamentos Todos los apartamentos.
     * @var int $apartamentoSeleccionado ID del apartamento seleccionado.
     * @var float $totalImporte Suma total de los importes de las facturas filtradas.
     */
    public $apartamento;
    public $facturas;
    public $apartment_id;
    public $apartamentos = []; // Todos los apartamentos
    public $apartamentoSeleccionado;  // ID del apartamento seleccionado
    public $totalImporte = 0; // Variable para la suma total

    // Y cargar las facturas del primer apartamento
    /**
     * Restablece los filtros y carga las facturas del primer apartamento.
     * 
     * Carga las facturas del primer apartamento.
     */
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

    /**
     * Inicializa el componente.
     * 
     * Carga todos los apartamentos y las facturas del primer apartamento.
     */
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

    /**
     * Se ejecuta automáticamente cuando cambia el apartamento seleccionado.
     * 
     * Si se llama manuelmente, se duplica el trabajo y se pueden producir errores.
     * 
     * @param int $apartamentoId ID del apartamento seleccionado.
     * @return void
     */
    public function updatedApartamentoSeleccionado($apartamentoId)
    {
        $this->totalImporte = 0; // Restablecer la suma total

        $this->resetPage(); // Resetea a la página 1 cuando cambia el filtro

        // Buscar el apartamento por ID, si está seleccionado
        $this->apartamento = $apartamentoId ? Apartment::find($apartamentoId) : null;
        $this->facturas = Factura::where('apartment_id', $this->apartamento->id)->get();
    }

    /**
     * Busca facturas según los filtros aplicados.
     * 
     * Este método calcula la suma total de los importes de las facturas filtradas.
     * 
     * @return void
     */
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

    /**
     * Renderiza el componente.
     * 
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.admin.facturas-index');
    }
}
