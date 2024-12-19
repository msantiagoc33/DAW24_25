<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;

/**
 * Class UserController - Controlador para la gestión de usuarios
 * 
 * @package App\Http\Controllers\Admin
 * @version 1.0
 * @since 1.0
 * @see View
 * @see Request
 * @see User
 * @see Role
 * @see Auth
 * @see Controller
 * @author Manuel Santiago Cabeza
 * 
 */
class UserController extends Controller
{
    /**
     * Muestra la vista principal de usuarios
     * 
     * @return View - Vista principal de usuarios
     */
    public function index(): View
    {
        return view('admin.users.index');
    }

    /**
     * Muestra la vista de creación de usuarios
     * 
     * @return View - Vista de creación de usuarios
     */
    public function create(): View
    {
        return view('admin.users.create');
    }

    /**
     * Almacena un nuevo usuario en la base de datos
     * 
     * @param Request $request - Datos del usuario a almacenar
     * @return View - Vista principal de usuarios
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|min:3',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Usuario creado con éxito.');
    }

    /**
     * Muestra la vista de un usuario en concreto
     * 
     * @param User $user - Usuario a mostrar
     * @return View - Vista de un usuario en concreto
     */
    public function show(User $user)
    {
        $roles = Role::all();
        return view('admin.users.show', compact('user', 'roles'));
    }

    /**
     * Muestra la vista de edición de un usuario
     * 
     * @param User $user - Usuario a editar
     * @return View - Vista de edición de un usuario
     */
    public function edit(User $user): View
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Actualiza los datos de un usuario en la base de datos
     * 
     * @param Request $request - Datos del usuario a actualizar
     * @param User $user - Usuario a actualizar
     * @return View - Vista de edición de un usuario
     */
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

    /**
     * Elimina un usuario de la base de datos
     * 
     * @param User $user - Usuario a eliminar
     * @return View - Vista principal de usuarios
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Usuario eliminado con éxito.');
    }

    /**
     * Muestra la vista de asignación de roles a un usuario
     * 
     * @param User $user - Usuario a asignar roles
     * @return View - Vista de asignación de roles a un usuario
     */
    public function menu(): View
    {
        if (!Auth::check() || !Auth::user()->can('admin.bookings.index')) {
            return view('admin.bookings.index');  // Vista para usuarios con el permiso 'admin.bookings.index'
        }

        return view('admin.index');  // Vista para usuarios sin ese permiso
    }

}
