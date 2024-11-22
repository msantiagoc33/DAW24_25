<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $guarded = [];

    public function platform():BelongsTo{
        return $this->belongsTo(Platform::class,'platform_id', 'id'); 
    }

    public function client():BelongsTo{
        return $this->belongsTo(Client::class,'client_id', 'id'); 
    }

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}