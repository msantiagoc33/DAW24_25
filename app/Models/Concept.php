<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Concept extends Model
{
    protected $guarded = [];

    public function facturas():BelongsToMany
    {
        return $this->belongsToMany(Factura::class);
    }
}
