<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;


    protected $fillable=[
        'id',
        'text',
        'user_id',
        'tweet_id',
        'is_boosted',
        'location',
        'file',
        'vote_up',
        'vote_down',
    ];

    public function tweet()
    {
        return $this->belongsTo(Tweet::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vote()
    {
        return $this->hasMany(CommentsVote::class);
    }
}
