<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;


    public $guard = [];

    public function tweet()
    {
        $this->belongsTo(Tweet::class);
    }

    public function sender()
    {
        $this->belongsTo(User::class, 'user_id', 'sender_id');
    }

    public function receiver()
    {
        $this->belongsTo(User::class, 'user_id', 'receiver_id');
    }
}
