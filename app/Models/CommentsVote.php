<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentsVote extends Model
{
    use HasFactory;


    public $guard = [];


    public function comment()
    {
        $this->belongsTo(Comment::class);
    }

    public function user()
    {
        $this->belongsTo(User::class);
    }
}
