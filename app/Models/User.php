<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Role;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Foundation\Auth\Access\Authorizable;

/**
 * Class User
 * 
 * Representa un usuario de la aplicación.
 * 
 * Un usuario puede tener múltiples roles y permisos, y puede tener múltiples reservas asociadas.
 * Implementa la interfaz de autorización para gestionar permisos y roles.
 */
class User extends Authenticatable implements AuthorizableContract
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, Authorizable;

    /**
     * Los atributos que son asignables en masa.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Los atributos que deben estar ocultos.
     * 
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Los atributos que deben ser convertidos
     * 
     * @var array
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Cambia aleatoriamente la imagen tomada de la web para el perfil del usuario.
     */
    public function adminlte_image()
    {
        return 'https://picsum.photos/300/300';
    }

    /**
     * Obtiene los roles asociados a este usuario.
     * Relación muchos a muchos con la tabla `roles`.
     * 
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     *  Obtiene todos los permisos asociados a los roles del usuario, aplanando cualquier estructura anidada, 
     *  y luego elimina los permisos duplicados basándose en su id, devolviendo una colección de permisos únicos.
     * 
     *  - $this->roles, devuelve una colección de todos los roles que tiene un usuario.
     *  - flatMap(function ($role) { ... }) recorre cada uno de los roles y ejecuta la función.
     *  - flatMap, recoge todos los persmisos de cada uno de los roles y los junta en una sola colección. 
     *  - $role->permisos, devuelve una colección de todos los permisos asociados a un rol.
     *  - ->unique('id'), elimina los permisos duplicados.
     */
    public function getAllPermisos()
    {
        return $this->roles->flatMap(function ($role) {
            return $role->permisos;
        })->unique('id');
    }

    /**
     * Comprueba si el usuario tiene un permiso específico.
     * 
     * @param string $permission
     * @return bool
     */
    public function hasPermission($permission)
    {
        return $this->roles->flatMap(function ($role) {
            return $role->permisos->pluck('name');
        })->contains($permission);
    }

    /**
     * Obtiene todas las reservas asociadas a este usuario.
     * Relación uno a muchos con la tabla `bookings`.
     * 
     * @return HasMany
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Comprueba si el usuario tiene un rol específico.
     * 
     * @param string $roleName
     * @return bool
     */
    public function hasRole($roleName)
    {
        return $this->roles()->where('name', $roleName)->exists();
    }


}
