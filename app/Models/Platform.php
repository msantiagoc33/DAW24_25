<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Platform
 * 
 * Representa las plataformas de la aplicación.
 */
class Platform extends Model
{
    /**
     * Los atributos que son asignables en masa.
     *
     * @var array
     */
    protected $fillable = ['name'];
}
