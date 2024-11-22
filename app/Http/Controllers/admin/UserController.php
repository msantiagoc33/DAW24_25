<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Permiso;

class UserController extends Controller
{

    public function index(): View
    {
        return view('admin.users.index');
    }

    public function create(): View
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|min:3',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // if ($request->password != $request->password_confirmation) {
        //     return redirect()->route('admin.users.create')->with('error', 'Las contraseñas no coinciden.');
        // }   

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Usuario creado con éxito.');
    }

    public function show(User $user)
    {
        $roles = Role::all();
        return view('admin.users.show',compact('user', 'roles'));
    }

    public function edit(User $user): View
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);

        // accedemos al registro del usuario y a su relación con roles
        // el método sync coloca un registro en la tabla intermedia entre users y roles
        $user->roles()->sync($request->roles);

        $usuario = User::findOrFail($user->id);
        $usuario->update($request->all());

        // volvemos a la pagina de edición
        return redirect()->route('admin.users.edit', $user)->with('info', 'Se han asignado los roles al usuario.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Usuario eliminado con éxito.');

    }

    public function menu(): View
    {
        if (!auth()->user()->can('admin.user.index')) {
            return view('admin.users.index');  // Vista para usuarios con el permiso 'admin.user.index'
        }
    
        return view('dashboard');  // Vista para usuarios sin ese permiso
    }
}
