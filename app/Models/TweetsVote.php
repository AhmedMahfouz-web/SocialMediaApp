<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TweetsVote extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'tweet_id',
        'type'
    ];

    public function tweet()
    {
        $this->belongsTo(Tweet::class);
    }

    public function user()
    {
        $this->belongsTo(User::class);
    }
}
