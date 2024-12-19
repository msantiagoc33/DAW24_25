<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permiso;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

/**
 * Class RoleController. Controlador para la gestión de roles
 * 
 * @package App\Http\Controllers
 * @version 1.0
 * @since 1.0
 * @see Role
 * @see Permiso
 * @see User
 * @see View
 * @see Auth
 * @see Request
 */
class RoleController extends Controller
{
    /**
     * Muestra la vista de la gestión de roles
     * 
     * @return View Retorna la vista de la gestión de roles
     */
    public function index(): View
    {

        $roles = Role::all();
        $users = User::all();
        return view('admin.roles.index', compact('roles', 'users'));
    }

    /**
     * Muestra la vista de los roles asignados a un usuario
     * 
     * @return View Retorna la vista de los roles asignados a un usuario
     * @return Redirect Retorna la vista de login si el usuario no está autenticado
     */
    public function rolesAsignados()
    {
        if (Auth::check()) {
            $user = Auth::user(); // Obtiene el usuario autenticado
            $roles = $user->roles; // Obtiene los roles del usuario autenticado
            return view('roles.rolesAsignados', compact('user', 'roles'));
        } else {
            return redirect()->route('login')->with('error', 'Debe iniciar sesión para acceder a esta página.');
        }
    }

    /**
     * Muestra la vista de creación de un rol
     * 
     * @return View Retorna la vista de creación de un rol y asignación de permisos
     */
    public function create(): View
    {
        $permisos = Permiso::all();
        return view('admin.roles.create', compact('permisos'));
    }

    /**
     * Editar un rol y asignar permisos
     * 
     * @param Role $rol Rol a editar
     * @return View Retorna la vista de edición de un rol y asignación de permisos
     */
    public function edit(Role $rol): View
    {
        $permisos = Permiso::all();

        // El método load asegura que los permisos estén disponibles en $rol->permisos.
        $rol->load('permisos');

        return view('admin.roles.edit', compact('rol', 'permisos'));
    }

    /**
     * Actualizar un rol y/o sus permisos
     * 
     * @param Request $request Datos del formulario
     * @param Role $rol Rol a actualizar
     * 
     * @return Redirect Retorna la vista de edición de un rol con un mensaje de éxito
     */
    public function update(RoleRequest $request, Role $rol)
    {
        // Actualizar el rol
        $rol->update([
            'name' => $request->input('name'),
        ]);

        // Sincronizar permisos (asegurarse de que existan en la solicitud)
        $rol->permisos()->sync($request->input('permissions', [])); // Si no se envían permisos, limpia la relación 

        return redirect()->route('roles.edit', compact('rol'))->with('success', 'Rol actualizado.');
    }

    /**
     * Almacenar un rol
     * 
     * @param Request $request Datos del formulario
     * @return Redirect Retorna la vista de gestión de roles con un mensaje de éxito
     */
    public function store(RoleRequest $request)
    {

        // Crear el rol
        $role = Role::create([
            'name' => $request['name'],
        ]);

        // Asignar los permisos seleccionados al rol
        $role->permisos()->attach($request['permissions']);

        // Redirigir al usuario con un mensaje de éxito
        return redirect()->route('roles.index')->with('success', 'Rol y permisos creados correctamente.');
    }

    /**
     * Asignar un rol a un usuario
     * 
     * @return View Retorna la vista de asignación de roles a usuarios
     */
    public function asignarRoleToUser()
    {
        $users = User::all();
        $roles = Role::all();
        return view('roles.asignarRoleToUser', compact('users', 'roles'));
    }

    /**
     * Almacenar un rol a un usuario
     * 
     * @param Request $request Datos del formulario
     * @return Redirect Retorna la vista de roles asignados con un mensaje de éxito
     */
    public function storeRoleToUser(Request $request)
    {
        $request->validate([
            'role' => 'required|string|exists:roles,name',
            'user' => 'required|exists:users,id',
        ]);

        // Encuentra al usuario por ID
        $user = User::findOrFail($request->user);

        // Asigna el rol al usuario
        $user->assignRole($request->role);

        return redirect()->route('roles.rolesAsignados')->with('success', 'Rol asignado con exito.');
    }

    /**
     * Eliminar un rol
     * 
     * @param Role $rol Rol a eliminar
     * @return Redirect Retorna la vista de gestión de roles con un mensaje de éxito
     */
    public function destroy(Role $rol)
    {
        $rol->delete();
        return redirect()->route('roles.index')->with('success', 'Rol eliminado.');
    }
}
