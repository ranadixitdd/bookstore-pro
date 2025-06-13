<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes; // ✅ Include SoftDeletes

    protected $fillable = [
        'name',
        'email',
        'password',
        'bio',
        'profile_image',
        
        'is_admin',
        'is_blocked', // ✅ Ensure this field exists in the database
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_admin' => 'boolean',   // ✅ Cast admin status as boolean
        'is_blocked' => 'boolean', // ✅ Cast blocked status as boolean
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }
}
