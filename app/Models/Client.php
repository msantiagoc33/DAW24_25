<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** 
 * Class Client
 * 
 * Representa un cliente.
 * 
 * Gestiona la relación de los clientes con los países.
 */
class Client extends Model
{
    /**
     * Los atributos que se pueden asignar de manera masiva.
     */
    protected $fillable = [
        'name',
        'phone',
        'calle_numero',
        'ciudad',
        'provincia',
        'cp',
        'passport',
        'country_id'
    ];

    /**
     * Obtiene el país al que pertenece el cliente.
     * 
     * @return BelongsTo Una relación de muchos a uno.
     */
    public function pais(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

}
