<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientsRequest;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Country;
use Illuminate\Contracts\View\View;

/**
 * Controlador para la gestión de clientes
 * 
 * @package App\Http\Controllers\Admin
 * @version 1.0
 * @since 1.0
 * @see Client
 * @see Country
 * @see View
 * @see Request
 * @see Controller
 * @see ClientsRequest Validación de datos del cliente
 * @author Manuel Santiago Cabeza
 */
class ClientsController extends Controller
{
    /**
     * Muestra una lista de clientes utilizando un componente Livewire.
     * 
     * @return View Vista con la lista de clientes
     */
    public function index(): View
    {
        return view('admin.clients.index');
    }

    /**
     * Crea un nuevo cliente.
     * 
     * @return View Vista con el formulario para crear un nuevo cliente
     */
    public function create(): View
    {
        $countries = Country::all();
        return view('admin.clients.create', compact('countries')); 
    }

    /**
     * Almacena un nuevo cliente en la base de datos.
     * 
     * @param Request $request Datos del formulario
     * @return RedirectResponse Redirección a la lista de clientes
     */
    public function store(ClientsRequest $request)
    {
        Client::create($request->all());

        return redirect()->route('admin.bookings.create');
    }

    /**
     * Muestra un cliente en particular.
     * 
     * @param Client $client Cliente a mostrar
     * @return View Vista con los detalles del cliente
     */
    public function show(Client $client): View
    {
        return view('admin.clients.show', compact('client'));
    }

    /**
     * Edita un cliente en particular.
     * 
     * @param Client $client Cliente a editar
     * @return View Vista con el formulario para editar un cliente
     */
    public function edit(Client $client): View
    {
        $countries = Country::all();
        return view('admin.clients.edit', compact('client', 'countries'));
    }


    /**
     * Actualiza un cliente en particular.
     * 
     * @param Request $request Datos del formulario
     * @param Client $client Cliente a actualizar
     * @return RedirectResponse Redirección a la lista de clientes
     */
    public function update(ClientsRequest $request, Client $client)
    {

        $client->update($request->all());
        return redirect()->route('admin.clients.index');
    }

    /**
     * Elimina un cliente en particular.
     * 
     * @param Client $client Cliente a eliminar
     * @return RedirectResponse Redirección a la lista de clientes
     */
    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('admin.clients.index');
    }
}
