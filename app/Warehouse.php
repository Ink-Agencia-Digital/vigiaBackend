<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $fillable = [
        "apartment_id",
        "user_id",
        "item"
    ];
}
