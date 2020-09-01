<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use SoftDeletes;

    public const STATES = [
        0 => "espera",
        1 => "aceptado",
        2 => "rechazado"
    ];

    protected $fillable = [
        'user_id',
        'location_id',
        'event',
        'start',
        'end',
        'aproved'
    ];

    /** Relationship */

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** Accesor */

    public function getAprovedAttribute()
    {
        return self::STATES[$this->aproved];
    }
}
