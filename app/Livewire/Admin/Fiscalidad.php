<?php

namespace App\Livewire\Admin;

use App\Models\Apartment;
use App\Models\Booking;
use App\Models\Factura;

use Livewire\Component;
use Carbon\Carbon;

/**
 * Componente Livewire para la gestión de la fiscalidad de los apartamentos
 * 
 * Este componente permite:
 * - Seleccionar un apartamento y un año
 * - Calcular métricas fiscales como total de reservas, facturas, días ocupados e importe histórico.
 */
class Fiscalidad extends Component
{
    /**
     * Listado de apartamentos.
     * 
     * @var Collection
     */
    public $apartamentos;

    /**
     * Año seleccionado.
     * 
     * @var int|null
     */
    public $year; // Propiedad pública para enlazar con el input

    /**
     * ID del apartamento seleccionado.
     * 
     * @var int|null
     */
    public $apartment_id; // Apartamento seleccionado

    /**
     * Reservas del año seleccionado.
     * 
     * @var Collection
     */
    public $reservasAnnio; // Reservas del año seleccionado

    /**
     * Total de facturas del año seleccionado.
     * 
     * @var float
     */
    public $totalFacturas; // Total de facturas del año seleccionado

    /**
     * Total de días ocupados del año seleccionado.
     * 
     * @var int
     */
    public $totalDias; // Total de días ocupados del año seleccionado

    /**
     * Total del importe histórico de las reservas del año seleccionado.
     * 
     * @var float
     */
    public $totalHistorico; // Importe Total de los días ocupados del año seleccionado

    /**
     * Nombre del apartamento seleccionado.
     * 
     * @var string
     */
    public $nombreApartamento; // Nombre del apartamento seleccionado


    /**
     * Método que se ejecuta al inicializar el componente.
     * 
     * Se encarga de cargar los apartamentos disponibles.
     */
    public function mount()
    {
        $this->apartamentos = Apartment::all();
    }

    /**
     * Calcula las métricas fiscales para el apartamento y año seleccionados.
     * 
     * - Total de reservas del año.
     * - Total del importe histórico de reservas.
     * - Total del importe de facturas.
     * - Total de días ocupados.
     * 
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function calculoTotales()
    {
        $this->reset(['reservasAnnio', 'totalHistorico', 'totalFacturas', 'totalDias', 'nombreApartamento']);
        // Verificar que year y apartment_id tienen valores asignados antes de continuar
        if (empty($this->year) || empty($this->apartment_id)) {
            return; // Salir del método si alguno de los campos no está definido
        }

        // Validación de los datos de entrada antes de realizar las consultas
        $this->validate([
            'year' => 'required|integer|min:2000|max:' . date('Y'),
            'apartment_id' => 'required|exists:apartments,id',
        ]);


        // Obtener el nombre del apartamento seleccionado
        $this->nombreApartamento = Apartment::find($this->apartment_id)->name;

        // Rango de fechas de inicio y fin del año seleccionado
        $desde = Carbon::createFromDate($this->year, 1, 1);
        $hasta = Carbon::createFromDate($this->year, 12, 31);

        $desde = $desde->toDateString();
        $hasta = $hasta->toDateString();

        // Obtener las reservas del año seleccionado
        $this->reservasAnnio = Booking::whereBetween('fechaSalida', [$desde, $hasta])
            ->where('apartment_id', '=', $this->apartment_id)
            ->where('historico', '=', true)
            ->get();

        // Calcular el importe total histórico de las reservas
        $this->totalHistorico = Booking::whereBetween('fechaSalida', [$desde, $hasta])
            ->where('apartment_id', '=', $this->apartment_id)
            ->where('historico', '=', true)
            ->sum('importe') ?: 0;

        // Calcular el total de facturas entre las fechas seleccionadas
        $this->totalFacturas = Factura::whereBetween('fecha', [$desde, $hasta])
            ->where('apartment_id', $this->apartment_id)
            ->sum('importe') ?: 0;

        // Calcular el total de días ocupados entre las fechas seleccionadas
        $this->totalDias = Booking::whereBetween('fechaSalida', [$desde, $hasta])
            ->where('apartment_id', $this->apartment_id)
            ->selectRaw('SUM(DATEDIFF(fechaSalida, fechaEntrada)) as total_dias')
            ->value('total_dias');
    }

    /**
     * Método que renderiza la vista del componente.
     * 
     * @return \Illuminate\View\View
     */
    public function render()
    {
        
        return view('livewire.admin.fiscalidad');
    }
}
