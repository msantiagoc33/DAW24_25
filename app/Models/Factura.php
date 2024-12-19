<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Factura
 * 
 * Representa una factura.
 * 
 * Gestiona la información relacionada con los conceptos y el apartamento asociado a la factura.
 */
class Factura extends Model
{
    /**
     * Los atributos que no se pueden asignar masivamente.
     */
    protected $fillable = [
        'fecha',
        'importe',
        'notas',
        'file_uri',
        'apartment_id'
    ];

    /**
     * Relación muchos a muchos con Concept.
     * 
     * Una factura puede estar asociada con múltiples conceptos y un concepto puede estar en múltiples facturas.
     * 
     * @return BelongsToMany
     */
    public function concepts():BelongsToMany
    {
        return $this->belongsToMany(Concept::class);
    }

    /**
     * Relación muchos a uno con Apartment.
     * 
     * Una factura está asociada a un único apartamento.
     * 
     * @return BelongsTo
     */
    public function apartment(): BelongsTo
    {
        return $this->belongsTo(Apartment::class);
    }
}
