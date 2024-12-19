<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Role;

/**
 * Class Permiso
 * 
 * Representa un permiso que puede tener un rol.
 * 
 * Los permisos definen las acciones que un usuario puede realizar en la aplicación,
 * y están asociados a uno o más roles a través de una relación de muchos a muchos.
 */
class Permiso extends Model
{
    /**
     * Los atributos que son asignables en masa.
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Indica si el modelo debería ser marcado con la fecha de creación y actualización.
     */
    public $timestamps = false;

    /**
     * Define la relación de muchos a muchos entre los permisos y los roles.
     * 
     * Un permiso puede estar asociado a varios roles, y un rol puede tener varios permisos.
     * 
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

}
