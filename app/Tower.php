<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tower extends Model
{
    use SoftDeletes;
    protected $fillable = [
        "name",
        "complex_id"
    ];

    /** Relationships */

    public function apartments()
    {
        return $this->hasMany(Apartment::class);
    }
}
