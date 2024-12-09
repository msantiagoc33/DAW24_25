<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Apartment
 * 
 * Representa un apartamento en el sistema.
 * Este modelo contiene las relaciones y características asociadas a un apartamento.
 */
class Apartment extends Model
{
    /**
     * Indica que todos los campos de la tabla son asignables.
     * 
     * @var array
     */
    protected $guarded = [];

    /**
     * Relación uno a muchos con la tabla de facturas.
     * 
     * Un apartamento puede tener muchas facturas.
     * 
     * @return HasMany
     */
    public function facturas(): HasMany
    {
        return $this->hasMany(Factura::class);
    }
}