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
}
