<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlatformsRequest;
use Illuminate\Http\Request;
use App\Models\Platform;
use Illuminate\Contracts\View\View;

/**
 * Class PlatformsController Controlador para la gestión de plataformas
 * 
 * @package App\Http\Controllers\Admin
 * @version 1.0
 * @since 1.0
 * @category Controller
 * @see Platform
 * @see View
 * @see PlatformsRequest Valiedación de datos de las plataformas
 * @author Manuel Santiago Cabeza
 * 
 */
class PlatformsController extends Controller
{
    /**
     * Muestra la lista de plataformas
     * 
     * @return View Vista con la lista de plataformas
     */
    public function index(): View
    {
        $platforms = Platform::all();
        return view('admin.platforms.index', compact('platforms'));
    }

    /**
     * Muestra el formulario para crear una nueva plataforma
     * 
     * @return View Vista con el formulario para crear una nueva plataforma
     */
    public function create(): View
    {
        return view('admin.platforms.create');
    }

    /**
     * Almacena una nueva plataforma en la base de datos
     * 
     * @param Request $request Datos del formulario
     * @return RedirectResponse Redirección a la lista de plataformas
     */
    public function store(PlatformsRequest $request)
    {
        Platform::create($request->all());

        return redirect()->route('admin.platforms.index')->with('success', 'Plataforma creada.');
    }

    /**
     * Muestra los detalles de una plataforma
     * 
     * @param Platform $platform Plataforma a mostrar
     * @return View Vista con los detalles de la plataforma
     */
    public function show(Platform $platform): View
    {
        return view('admin.platforms.show', compact('platform'));
    }

    /**
     * Edita una plataforma en particular
     * 
     * @param Platform $platform Plataforma a editar
     * @return View Vista con el formulario para editar la plataforma
     */
    public function edit(Platform $platform): View
    {
        return view('admin.platforms.edit', compact('platform'));
    }

    /** 
     * Actualiza una plataforma en la base de datos
     * 
     * @param Request $request Datos del formulario
     * @param Platform $platform Plataforma a actualizar
     * @return RedirectResponse Redirección a la lista de plataformas
     */
    public function update(PlatformsRequest $request, Platform $platform)
    {

        $apartamento = Platform::findOrFail($platform->id);
        $apartamento->update($request->all());

        // volvemos a la pagina de edición
        return redirect()->route('admin.platforms.edit', $platform)->with('info', 'Se ha modificado la plataforma.');
    }

    /**
     * Elimina una plataforma en particular
     * 
     * @param Platform $platform Plataforma a eliminar
     * @return RedirectResponse Redirección a la lista de plataformas
     */
    public function destroy(Platform $platform)
    {
        $platform->delete();

        return redirect()->route('admin.platforms.index')->with('success', 'Plataforma eliminada.');
    }
}
