<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FacturasRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Models\Concept;
use App\Models\Apartment;
use App\Models\Factura;

/**
 * Controlador para gestionar las facturas.
 * 
 * @package App\Http\Controllers\Admin
 * @version 1.0
 * @since 1.0
 * @see Factura
 * @see Concept
 * @see Apartment
 * @see Controller
 * @see Request
 * @see FacturasRequest Valida los datos de la factura
 * @see View
 * @author Manuel Santiago Cabeza
 */
class FacturasController extends Controller
{
    /**
     * Lista todas las facturas.
     * 
     * @return View Vista con la lista de facturas
     */
    public function index(): View
    {
        return view('admin.facturas.index');
    }

    /** 
     * Muestra el formulario para crear una nueva factura.
     * 
     * @return View Vista con el formulario para crear una nueva factura
     */
    public function create(): View
    {
        $conceptos = Concept::all();
        $apartamentos = Apartment::all();
        return view('admin.facturas.create', compact('conceptos', 'apartamentos'));
    }

    /** 
     * Almacena una nueva factura en la base de datos.
     * 
     * @param Request $request Datos del formulario
     * @return RedirectResponse Redirección a la lista de facturas
     */
    public function store(FacturasRequest $request)
    {

        // Subir el archivo (si existe)
        $file_uri = null;
        if ($request->hasFile('file_uri')) {
            $file_uri = $request->file('file_uri')->store('facturas', 'public');
        }

        // Crear la nueva factura
        $factura = Factura::create([
            'fecha' => $request['fecha'],
            'importe' => $request['importe'],
            'notas' => $request['notas'] ?? null,
            'file_uri' => $file_uri,
            'apartment_id' => $request['apartment_id'],
        ]);

        // Asignar los conceptos seleccionados a la factura
        $factura->concepts()->attach($request['conceptos']);

        return redirect()->route('admin.facturas.index')->with('success', 'Factura creada correctamente');
    }

    /**
     * Muestra una factura en particular.
     */
    public function show(Factura $factura)
    {
        return view('admin.facturas.show', compact('factura'));
    }

    /**
     * Muestra el formulario para editar una factura.
     * 
     * @param Factura $factura Factura a editar
     * @return View Vista con el formulario para editar una factura
     */
    public function edit(Factura $factura): View
    {
        $conceptos = Concept::all();
        $apartamentos = Apartment::all();
        return view('admin.facturas.edit', compact('factura', 'conceptos', 'apartamentos'));
    }

    /**
     * Actualiza la factura en la base de datos.
     * 
     * @param Request $request Datos del formulario
     * @param Factura $factura Factura a actualizar
     * @return RedirectResponse Redirección a la lista de facturas
     */
    public function update(FacturasRequest $request, Factura $factura)
    {

        // Subir el archivo (si existe)
        if ($request->hasFile('file_uri')) {
            $file_uri = $request->file('file_uri')->store('facturas', 'public');
            $factura->update(['file_uri' => $file_uri]);
        }

        // Actualizar la factura
        $factura->update([
            'fecha' => $request->fecha,
            'importe' => $request->importe,
            'notas' => $request->notas ?? null,
            'apartment_id' =>  $request->apartment_id,
        ]);

        // Actualizar los conceptos de la factura
        $factura->concepts()->sync($request->conceptos);

        return redirect()->route('admin.facturas.edit', $factura)->with('success', 'Factura actualizada correctamente');
    }

    /**
     * Elimina la factura de la base de datos.
     * 
     * @param Factura $factura Factura a eliminar
     * @return RedirectResponse Redirección a la lista de facturas
     */
    public function destroy(Factura $factura)
    {
        $factura->delete();
        return redirect()->route('admin.facturas.index')->with('success', 'Factura eliminada correctamente');
    }

    /**
     * Busca facturas en la base de datos.
     * 
     * @param Request $request Datos del formulario
     * @return View Vista con los resultados de la búsqueda
     */
    public function busqueda(Request $request)
    {
        dd($request->all());
        return view('admin.facturas.index');
    }
}
