<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Apartment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'tower_id'
    ];

    /** Relationships */

    public function users()
    {
        $this->belongsToMany(User::class, 'users_apartments');
    }

    public function codes()
    {
        $this->hasMany(Code::class);
    }

    public function warehouses()
    {
        $this->hasMany(Warehouse::class);
    }
}
