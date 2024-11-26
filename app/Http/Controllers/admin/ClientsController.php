<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Country;
use Illuminate\Contracts\View\View;

class ClientsController extends Controller
{
    /**
     * Muestra una lista de clientes utilizando un compoente Livewire.
     */
    public function index():View
    {        
        return view('admin.clients.index');
    }

    /**
     * Crea un nuevo cliente.
     */
    public function create():View
    {
        $countries = Country::all();
        return view('admin.clients.create', compact('countries'));    
    }

    /**
     * Almacena un nuevo cliente en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'nullable',
            'calle_numero' => 'nullable',
            'ciudad' => 'nullable',
            'provincia' => 'nullable',
            'cp' => 'nullable',
            'passport' => 'nullable',
            'country_id' => 'required',
        ]);

        Client::create($request->all());
        return redirect()->route('admin.bookings.create');
    }

    /**
     * Muestra un cliente en particular.
     */
    public function show(Client $client):View
    {
        return view('admin.clients.show',compact('client'));
    }

    /**
     * Edita un cliente en particular.
     */
    public function edit(Client $client):View
    {
        $countries = Country::all();
        return view('admin.clients.edit', compact('client','countries'));
    }


    /**
     * Actualiza un cliente en particular.
     */
    public function update(Request $request, Client $client)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'nullable',
            'calle_numero' => 'nullable',
            'ciudad' => 'nullable',
            'provincia' => 'nullable',
            'cp' => 'nullable',
            'passport' => 'nullable',
            'country_id' => 'required',
        ]);

        $client->update($request->all());
        return redirect()->route('admin.clients.index');
    }

    /**
     * Elimina un cliente en particular.
     */
    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('admin.clients.index');
    }
}
