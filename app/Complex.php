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


    /** RELATIONSHIPS */

    public function towers()
    {
        return $this->hasMany(Tower::class);
    }
}
