<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "complex_id",
        "name",
        "opening",
        "closing"
    ];

    /** Relationships */

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function complex()
    {
        return $this->belongsTo(Complex::class);
    }
}
