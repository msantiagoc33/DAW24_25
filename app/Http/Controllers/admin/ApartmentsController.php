<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Apartment;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

/**
 * Controlador para la gestión de apartamentos
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
    public function store(Request $request): RedirectResponse
    {

        $data = $request->validate([
            'name' => 'required|string|max:255|min:3',
            'address' => 'required|string|',
            'description' => 'string|nullable',
            'rooms' => 'integer|min:1|required',
            'capacidad' => 'integer|min:1|required'
        ]);

        Apartment::create($data);

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
    public function update(Request $request, Apartment $apartment): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|min:3',
            'address' => 'required|string|',
            'description' => 'string|nullable',
            'rooms' => 'integer|min:1|required',
            'capacidad' => 'integer|min:1|required'
        ], [
            'name.required' => 'El nombre del apartamento es obligatorio.',
            'address.required' => 'La dirección es obligatoria.',
            'rooms.integer' => 'El número de habitaciones debe ser un número entero.',
        ]);

        $apartment->update($data);

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
