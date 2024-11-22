<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Platform;
use Illuminate\Contracts\View\View;

class PlatformsController extends Controller
{

    public function index(): View
    {
        $platforms = Platform::all();
        return view('admin.platforms.index', compact('platforms'));
    }

    public function create(): View
    {
        return view('admin.platforms.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|min:3'
        ]);

        Platform::create($request->all());

        return redirect()->route('admin.platforms.index')->with('success', 'Plataforma creada.');
    }

    public function show(Platform $platform): View
    {
        return view('admin.platforms.show', compact('platform'));
    }


    public function edit(Platform $platform): View
    {
        return view('admin.platforms.edit', compact('platform'));
    }


    public function update(Request $request, Platform $platform)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $apartamento = Platform::findOrFail($platform->id);
        $apartamento->update($request->all());

        // volvemos a la pagina de edición
        return redirect()->route('admin.platforms.edit', $platform)->with('info', 'Se ha modificado la plataforma.');
    }

    public function destroy(Platform $platform)
    {
        $platform->delete();

        return redirect()->route('admin.platforms.index')->with('success', 'Plataforma eliminada.');
    }
}
