<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "sender_id",
        "chat_id",
        "message",
    ];


    public function sender()
    {
        return $this->belongsTo(User::class, "sender_id");
    }
}
