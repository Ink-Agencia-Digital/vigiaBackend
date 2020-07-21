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
        'visitor'
    ];
}
