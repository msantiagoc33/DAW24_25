<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permiso;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function index(): View
    {

        $roles = Role::all();
        $users = User::all();
        return view('admin.roles.index', compact('roles', 'users'));
    }

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

    public function create(): View
    {
        $permisos = Permiso::all();
        return view('admin.roles.create', compact('permisos'));
    }

    /**
     * Editar un rol y asignar permisos
     */
    public function edit(Role $rol): View
    {
        $permisos = Permiso::all();

        // El método load asegura que los permisos estén disponibles en $rol->permisos.
        $rol->load('permisos');

        return view('admin.roles.edit', compact('rol', 'permisos'));
    }

    /**
     * Actualizar un rol y sus permisos
     */
    public function update(Request $request, Role $rol)
    {
        // Validar el nombre del rol
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

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
     */
    public function store(Request $request)
    {
        // Validar los datos recibidos del formulario
        $validated = $request->validate([
            'role_name' => 'required|string|unique:roles,name',
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permisos,id',
        ]);

        // Crear el rol
        $role = Role::create([
            'name' => $validated['role_name'],
        ]);

        // Asignar los permisos seleccionados al rol
        $role->permisos()->attach($validated['permissions']);

        // Role::create($request->all());
        // Redirigir al usuario con un mensaje de éxito
        return redirect()->route('roles.index')->with('success', 'Rol y permisos creados correctamente.');
        // return redirect()->route('roles.index')->with('success', 'Rol creado.');
    }

    /**
     * Asignar un rol a un usuario
     */
    public function asignarRoleToUser()
    {
        $users = User::all();
        $roles = Role::all();
        return view('roles.asignarRoleToUser', compact('users', 'roles'));
    }

    /**
     * Almacenar un rol a un usuario
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

    public function destroy()
    {
        //
    }
}
