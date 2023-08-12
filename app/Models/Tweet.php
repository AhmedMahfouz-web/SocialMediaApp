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
        'latitude',
        'longitude',
        'country',
        'color',
        'user_id',
        'vote_up',
        'vote_down',
        'is_boosted',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function votes()
    {
        return $this->hasMany(TweetsVote::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function chats()
    {
        return $this->hasMany(Chat::class);
    }
}
