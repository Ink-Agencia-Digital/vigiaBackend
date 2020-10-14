<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chat extends Model
{
    use SoftDeletes;

    protected $fillable = ["name"];

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_chats');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
