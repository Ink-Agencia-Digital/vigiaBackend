<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Code extends Model
{

    use SoftDeletes;

    protected $fillable = [
        "apartment_id",
        "user_id",
        'visitor',
        'photo'
    ];

    /** Relationships */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }
}
