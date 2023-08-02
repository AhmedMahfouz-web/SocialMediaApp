<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
        'file',
        'location',
        'user_id',
        'vote_up',
        'vote_down',
        'is_boosted',
    ];

    public function user()
    {
        $this->belongsTo(User::class);
    }

    public function vote()
    {
        $this->hasMany(TweetsVote::class);
    }

    public function comment()
    {
        $this->hasMany(Comment::class);
    }

    public function chat()
    {
        $this->hasMany(Chat::class);
    }
}
