<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * class Country
 * 
 * Representa la tabla countries y su relación con la tabla clients
 */
class Country extends Model
{
    /**
     * Define los campos que no se pueden asignar masivamente
     */
    protected $fillable = [
        'name'
    ];

    /**
     * @return hasMany Define la relación uno a muchos con la tabla clients
     */
    public function clients(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Client::class);
    }
}
