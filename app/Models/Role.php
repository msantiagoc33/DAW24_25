<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Permiso;
use App\Models\User;

class Role extends Model
{
    protected $fillable = ['name'];

    public $timestamps = false;

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function permisos(): BelongsToMany
    {
        return $this->belongsToMany(Permiso::class);
    }
}
