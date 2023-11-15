<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'token',
        'register_at',
    ];

    public function order()
    {
        $this->hasMany(Order::class);
    }

    public function wallet()
    {
        $this->hasOne(Wallet::class);
    }

    protected $with = ['order','wallet'];
}
