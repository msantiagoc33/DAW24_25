<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Apartment extends Model
{
    protected $guarded = [];

    public function facturas(): HasMany
    {
        return $this->hasMany(Factura::class);
    }
}