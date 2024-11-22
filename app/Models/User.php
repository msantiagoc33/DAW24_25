<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Role;
use Illuminate\Database\Eloquent\Relations\HasMany;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;


    protected $fillable = [
        'name',
        'email',
        'password',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function adminlte_image()
    {
        return 'https://picsum.photos/300/300';
    }


    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }


    public function getAllPermisos()
    {
        return $this->roles->flatMap(function ($role) {
            return $role->permisos;
        })->unique('id');
    }

    public function hasPermission($permission)
    {
        return $this->roles->flatMap(function ($role) {
            return $role->permisos->pluck('name');
        })->contains($permission);
    }


    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function hasRole($roleName)
    {
        return $this->roles()->where('name', $roleName)->exists();
    }
}
