<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApartmentRequest;
use Illuminate\Http\Request;
use App\Models\Apartment;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

/**
 * Controlador para la gestión de apartamentos
 * 
 * @package App\Http\Controllers\Admin
 * @version 1.0
 * @since 1.0
 * @see Apartment
 * @see Request
 * @see View
 * @see RedirectResponse
 * @see ApartmentRequest
 * @link https://laravel.com/docs/8.x/controllers
 * @author Manuel Santiago Cabezas
 */
class ApartmentsController extends Controller
{
    /**
     * Muestra la lista de apartamentos
     * @return View Vista con la lista de apartamentos
     */
    public function index(): View
    {
        $apartments = Apartment::all();
        return view('admin.apartments.index', compact('apartments'));
    }

    /**
     * Muestra el formulario para crear un nuevo apartamento
     * @return View Vista con el formulario para crear un nuevo apartamento
     */
    public function create(): View
    {
        return view('admin.apartments.create');
    }

    /**
     * Guarda un nuevo apartamento en la base de datos
     * @param Request $request Datos del formulario
     * @return RedirectResponse Redirección a la lista de apartamentos
     */
    public function store(ApartmentRequest $request): RedirectResponse
    {

        Apartment::create($request->all());

        return redirect()->route('admin.apartments.index')->with('success', 'Apartamento creado con éxito.');
    }

    /**
     * Muestra los detalles de un apartamento
     * @param Apartment $apartment Apartamento a mostrar
     * @return View Vista con los detalles del apartamento
     */
    public function show(Apartment $apartment)
    {
        return view('admin.apartments.show', compact('apartment'));
    }


    /**
     * Muestra el formulario para editar un apartamento
     * @param Apartment $apartment Apartamento a editar
     * @return View Vista con el formulario para editar un apartamento
     */
    public function edit(Apartment $apartment): View
    {
        return view('admin.apartments.edit', compact('apartment'));
    }


    /**
     * Actualiza un apartamento en la base de datos
     * @param Request $request Datos del formulario
     * @param Apartment $apartment Apartamento a actualizar
     * @return RedirectResponse Redirección a la lista de apartamentos
     */
    public function update(ApartmentRequest $request, Apartment $apartment): RedirectResponse
    {
        $apartment->update($request->all());

        // volvemos a la pagina de edición
        return redirect()->route('admin.apartments.edit', $apartment)->with('success', 'Apartamento creado correctamente.');
    }

    /**
     * Elimina un apartamento de la base de datos
     * @param Apartment $apartment Apartamento a eliminar
     * @return RedirectResponse Redirección a la lista de apartamentos
     */
    public function destroy(Apartment $apartment)
    {
        $apartment->delete();

        return redirect()->route('admin.apartments.index')->with('success', 'Apartamento eliminado.');
    }
}
