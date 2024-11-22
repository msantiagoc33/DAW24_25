<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permiso;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $permisosConRoles = [
            'admin.home' => ['Administrador', 'Editor'],
            'admin.user.index' => ['Administrador'],
            'admin.user.edit' => ['Administrador'],
            'admin.user.update' => ['Administrador'],

            'admin.apartment.index' => ['Administrador', 'Editor', 'Consultor'],
            'admin.apartment.create' => ['Administrador'],
            'admin.apartment.edit' => ['Administrador', 'Editor'],
            'admin.apartment.destroy' => ['Administrador'],

            'admin.booking.index' => ['Administrador', 'Editor', 'Consultor'],
            'admin.booking.create' => ['Administrador'],
            'admin.booking.edit' => ['Administrador', 'Editor'],
            'admin.booking.destroy' => ['Administrador'],

            'admin.concept.index' => ['Administrador', 'Editor', 'Consultor'],
            'admin.concept.create' => ['Administrador'],
            'admin.concept.edit' => ['Administrador', 'Editor'],
            'admin.concept.destroy' => ['Administrador'],

            'admin.factura.index' => ['Administrador', 'Editor', 'Consultor'],
            'admin.factura.create' => ['Administrador'],
            'admin.factura.edit' => ['Administrador', 'Editor'],
            'admin.factura.destroy' => ['Administrador'],

            'admin.platform.index' => ['Administrador', 'Editor', 'Consultor'],
            'admin.platform.create' => ['Administrador'],
            'admin.platform.edit' => ['Administrador', 'Editor'],
            'admin.platform.destroy' => ['Administrador'],

            'admin.client.index' => ['Administrador', 'Editor', 'Consultor'],
            'admin.client.create' => ['Administrador'],
            'admin.client.edit' => ['Administrador', 'Editor'],
            'admin.client.destroy' => ['Administrador'],

            'admin.country.index' => ['Administrador', 'Editor', 'Consultor'],
            'admin.country.create' => ['Administrador'],
            'admin.country.edit' => ['Administrador', 'Editor'],
            'admin.country.destroy' => ['Administrador'],
        ];

        // Iteramos sobre el array y asignamos los roles a cada permiso
        foreach ($permisosConRoles as $permisoNombre => $roles) {
            // Crea el permiso si no existe
            $permiso = Permiso::firstOrCreate(['name' => $permisoNombre]);

            // Asigna cada rol al permiso
            foreach ($roles as $rolNombre) {
                $role = Role::firstOrCreate(['name' => $rolNombre]);
                $role->permisos()->attach($permiso->id); // Añade el permiso al rol
            }
        }
    }
}
