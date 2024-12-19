<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Concept
 * 
 * Representa los cocneptos de una factura
 */
class Concept extends Model
{
    /**
     * Define los campos que no se pueden asignar masivamente
     */ 
    protected $fillable = [
        'name'
    ];

    /**
     * @return BelongsToMany Relación muchos a muchos con Factura
     */
    public function facturas():BelongsToMany
    {
        return $this->belongsToMany(Factura::class);
    }
}
