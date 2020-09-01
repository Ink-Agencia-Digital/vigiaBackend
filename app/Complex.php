<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Complex extends Model
{

    use SoftDeletes;

    protected $fillable = [
        "name",
        "address",
        "lat",
        "lng",
        "geofence"
    ];


    protected $casts = [
        'geofence' => 'array',
    ];


    /** RELATIONSHIPS */

    public function towers()
    {
        return $this->hasMany(Tower::class);
    }

    public function locations()
    {
        return $this->hasMany(Location::class);
    }

    public function reservations()
    {
        return $this->hasManyThrough(Reservation::class, Location::class);
    }

    public function employees()
    {
        return $this->belongsToMany(User::class, 'users_complexes')->whereHas('roles', function ($query) {
            return $query->where('roles.name', 'employee');
        });
    }
}
