<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Booking
 * 
 * Representa una reserva de un apartamento.
 */
class Booking extends Model
{
    /**
     * Indica qué campos no se pueden asignar masivamente.
     * 
     * @var array
     */
    protected $fillable = [
        'fechaEntrada',
        'fechaSalida',
        'huespedes',
        'importe',
        'comentario',
        'historico',
        'platform_id',
        'client_id',
        'apartment_id',
        'user_id'
    ];


    /**
     * Indica qué campos se deben convertir a un tipo de dato específico.
     * 
     * @var array
     */
    protected $casts = [
        'fechaEntrada' => 'date',
        'fechaSalida' => 'date',
        'historico' => 'boolean',
    ];

    /**
     * Relacion con el modelo Platform.
     * 
     * @return BelongsTo Una relación de muchos a uno.
     * 
     */
    public function platform(): BelongsTo
    {
        return $this->belongsTo(Platform::class, 'platform_id', 'id');
    }

    /**
     * Relacion con el modelo Client.
     * 
     * @return BelongsTo Una relación de muchos a uno.
     * 
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    /**
     * Relacion con el modelo User.
     * 
     * @return BelongsTo Una relación de muchos a uno.
     * 
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relacion con el modelo Apartment.
     * 
     * @return BelongsTo Una relación de muchos a uno.
     * 
     */
    public function apartment(): BelongsTo
    {
        return $this->belongsTo(Apartment::class, 'apartment_id', 'id');
    }

}
