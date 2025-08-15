<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Card[] $cards
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Loan[] $loans
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password'];
    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function cards()
    {
        return $this->hasMany(\App\Models\Card::class);
    }

    public function loans()
    {
        return $this->hasMany(\App\Models\Loan::class);
    }
}
