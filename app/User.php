<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes, HasApiTokens, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'lastname',
        'phone',
        'identification',
        'email',
        'ice',
        'photo',
        'password'
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes["password"] = Hash::make($value);
    }


    /** Relationships */

    public function apartments()
    {
        return $this->belongsToMany(Apartment::class, 'users_apartments');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function complex_administrator()
    {
        return $this->belongsToMany(Complex::class, 'users_complexes');
    }

    public function devices()
    {
        return $this->hasMany(Device::class);
    }

    public function chats()
    {
        return $this->belongsToMany(Chat::class, 'users_chats');
    }
}
