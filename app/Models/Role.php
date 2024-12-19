<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Permiso;
use App\Models\User;

/**
 * Class Role
 * 
 * Representa los roles de la aplicación
 * 
 * Un rol puede estar asociado a varios usuarios y tener varios permisos,
 * mediante una relación de muchos a muchos.
 */
class Role extends Model
{
    /**
     * Los atributos que son asignables en masa.
     */
    protected $fillable = ['name'];

    /**
     * Indica si el modelo debería ser marcado con marcas de tiempo.
     */
    public $timestamps = false;

    /**
     * Obtiene los usuarios asociados a este rol.
     * Relación muchos a muchos con la tabla `users`.
     * 
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Obtiene los permisos asociados a este rol.
     * Relación muchos a muchos con la tabla `permisos`.
     * 
     * @return BelongsToMany
     */
    public function permisos(): BelongsToMany
    {
        return $this->belongsToMany(Permiso::class);
    }
}
