<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Concept;
use Exception;
use Illuminate\View\View;
use Livewire\WithPagination;
class ConceptsController extends Controller
{


    public function index(): View
    {
        return view('admin.concepts.index');
    }

    public function create(): View
    {
        return view('admin.concepts.create'); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|min:3|unique:concepts,name',
        ]);

        Concept::create($request->all());

        return redirect()->route('admin.concepts.index')->with('success', 'Concepto creado.');
    }

    public function show(Concept $concept): View
    {
        return view('admin.concepts.show', compact('concept'));
    }

    public function edit(Concept $concept): View
    {
        return view('admin.concepts.edit', compact('concept'));
    }


    public function update(Request $request, Concept $concept)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:concepts,name',
        ]);

        $concepto = Concept::findOrFail($concept->id);
        $concepto->update($request->all());

        // volvemos a la pagina de edición
        return redirect()->route('admin.concepts.edit', $concept)->with('info', 'Se ha modificado el concepto.');
    }


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
