<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Models\Concept;
use App\Models\Apartment;
use App\Models\Factura;

class FacturasController extends Controller
{
    /**
     * Lista todas las facturas.
     */
    public function index(): View
    {
        return view('admin.facturas.index');
    }

    /** 
     * Muestra el formulario para crear una nueva factura.
     */
    public function create(): View
    {
        $conceptos = Concept::all();
        $apartamentos = Apartment::all();
        return view('admin.facturas.create', compact('conceptos', 'apartamentos'));
    }


    /** 
     * Almacena una nueva factura en la base de datos.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'fecha' => 'required|date',
            'importe' => 'required|numeric',
            'notas' => 'nullable|string',
            'file_uri' => 'nullable|file|mimes:pdf,jpeg,png,jpg,docx',
            'apartment_id' => 'required|exists:apartments,id',
            'conceptos' => 'required|array',
        ]);

        // Subir el archivo (si existe)
        $file_uri = null;
        if ($request->hasFile('file_uri')) {
            $file_uri = $request->file('file_uri')->store('facturas', 'public');
        }

        // Crear la nueva factura
        $factura = Factura::create([
            'fecha' => $validated['fecha'],
            'importe' => $validated['importe'],
            'notas' => $validated['notas'] ?? null,
            'file_uri' => $file_uri,
            'apartment_id' => $validated['apartment_id'],
        ]);

        // Asignar los conceptos seleccionados a la factura
        $factura->concepts()->attach($validated['conceptos']);

        return redirect()->route('admin.facturas.index')->with('success', 'Factura creada correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Muestra el formulario para editar una factura.
     */
    public function edit(Factura $factura): View
    {
        $conceptos = Concept::all();
        $apartamentos = Apartment::all();
        return view('admin.facturas.edit', compact('factura', 'conceptos', 'apartamentos'));
    }

    /**
     * Actualiza la factura en la base de datos.
     */
    public function update(Request $request, Factura $factura)
    {

        // Validar los datos del formulario
        $request->validate([
            'fecha' => 'required|date',
            'importe' => 'required|numeric',
            'notas' => 'nullable|string',
            'file_uri' => 'nullable|file|mimes:pdf,jpeg,png,jpg',
            'apartment_id' => 'required|exists:apartments,id',
            'conceptos' => 'required|array',
        ]);

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
     */
    public function destroy(Factura $factura)
    {
        $factura->delete();
        return redirect()->route('admin.facturas.index')->with('success', 'Factura eliminada correctamente');
    }

    public function busqueda(Request $request)
    {
        dd($request->all());
        return view('admin.facturas.index');
    }
}
