<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Apartment;
use Illuminate\Contracts\View\View;

class ApartmentsController extends Controller
{

    public function index(): View
    {
        $apartments = Apartment::all();
        return view('admin.apartments.index', compact('apartments'));
    }


    public function create(): View
    {
        return view('admin.apartments.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|min:3',
            'address' => 'required|string|',
            'description' => 'string',
            'rooms' => 'string',
            'guests' => 'string'
        ]);

        // Apartment::create([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'password' => bcrypt($request->password),
        // ]);
        Apartment::create($request->all());

        return redirect()->route('admin.apartments.index')->with('success', 'Apartamento creado con éxito.');
    }

    public function show(Apartment $apartment)
    {
        return view('admin.apartments.show',compact('apartment'));
    }


    public function edit(Apartment $apartment): View
    {
        return view('admin.apartments.edit', compact('apartment'));
    }


    public function update(Request $request, Apartment $apartment)
    {
        $request->validate([
            'name' => 'required|string|max:255|min:3',
            'address' => 'required|string|',
            'description' => 'string',
            'rooms' => 'string',
            'guests' => 'string'
        ]);

        $apartamento = Apartment::findOrFail($apartment->id);
        $apartamento->update($request->all());

        // volvemos a la pagina de edición
        return redirect()->route('admin.apartments.edit', $apartment)->with('info', 'Se han modificado el apartamento.');
    }

    public function destroy(Apartment $apartment)
    {
        $apartment->delete();

        return redirect()->route('admin.apartments.index')->with('success', 'Apartamento eliminado.');
    }
}
