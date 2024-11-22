<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Role;

class Permiso extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

}
