<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConceptsRequest;
use Illuminate\Http\Request;
use App\Models\Concept;
use Exception;
use Illuminate\View\View;


/**
 * Controlador para gestionar los conceptos.
 * 
 * @package App\Http\Controllers\Admin
 * @version 1.0.0
 * @since 1.0.0
 * @see Concept
 * @see Request
 * @see View
 * @see ConceptsRequest Validación de los datos del concepto
 * @see Exception
 * @see Controller
 * @author Manuel Santiago Cabeza
 */
class ConceptsController extends Controller
{
    /**
     * Listado de conceptos
     * 
     * @return View Vista con el listado de conceptos
     */
    public function index(): View
    {
        return view('admin.concepts.index');
    }

    /**
     * Crear un nuevo concepto
     * 
     * @return View Vista con el formulario para crear un nuevo concepto
     */
    public function create(): View
    {
        return view('admin.concepts.create'); 
    }

    /**
     * Almacenar un nuevo concepto en la base de datos
     * 
     * @param Request $request Datos del formulario
     * @return RedirectResponse Redirección a la lista de conceptos
     */
    public function store(ConceptsRequest $request)
    {

        Concept::create($request->all());

        return redirect()->route('admin.concepts.index')->with('success', 'Concepto creado.');
    }

    /**
     * Muestra un concepto en particular
     * 
     * @param Concept $concept Concepto a mostrar
     * @return View Vista con los detalles del concepto
     */
    public function show(Concept $concept): View
    {
        return view('admin.concepts.show', compact('concept'));
    }

    public function edit(Concept $concept): View
    {
        return view('admin.concepts.edit', compact('concept'));
    }

    /**
     * Edita un concepto en particular
     * 
     * @param Request $request Datos del formulario
     * @param Concept $concept Concepto a editar
     * @return RedirectResponse Redirección a la lista de conceptos
     */
    public function update(ConceptsRequest $request, Concept $concept)
    {

        $concepto = Concept::findOrFail($concept->id);
        $concepto->update($request->all());

        // volvemos a la pagina de edición
        return redirect()->route('admin.concepts.edit', $concept)->with('info', 'Se ha modificado el concepto.');
    }

    /**
     * Elimina un concepto en particular
     * 
     * @param Concept $concept Concepto a eliminar
     * @return RedirectResponse Redirección a la lista de conceptos
     */
    public function destroy(Concept $concept)
    {
        try{
            $concept->delete();
            return redirect()->route('admin.concepts.index')->with('success', 'Concepto eliminado.');
        }catch(Exception $e){
            return redirect()->route('admin.concepts.index')->with('error', 'Error al eliminar el concepto. Puede que esté relacionado con alguna factura.');
        }
    }
}
