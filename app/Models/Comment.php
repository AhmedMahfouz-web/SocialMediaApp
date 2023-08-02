<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;


    public $guard = [];

    public function tweet()
    {
        $this->belongsTo(Tweet::class);
    }

    public function user()
    {
        $this->belongsTo(User::class);
    }

    public function vote()
    {
        $this->hasMany(CommentsVote::class);
    }
}
