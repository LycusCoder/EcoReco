<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'preferences' => 'array', // Casting untuk kolom JSON
    ];

    // Relasi ke tabel orders
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Relasi ke tabel ratings
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    // Relasi ke tabel recommendations
    public function recommendations()
    {
        return $this->hasMany(Recommendation::class);
    }
}
