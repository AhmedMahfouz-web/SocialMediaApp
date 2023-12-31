<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // public $guard = [];

    protected $fillable = [
        'nickname',
        'imei',
        'password',
        'gender',
        'age',
        'country',
        'ban',
        'ban_end',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function tweet()
    {
        $this->hasMany(Tweet::class);
    }

    public function tweetVote()
    {
        $this->hasMany(TweetsVote::class);
    }

    public function comment()
    {
        $this->hasMany(Comment::class);
    }

    public function commentVote()
    {
        $this->hasMany(CommentsVote::class);
    }

    public function chat()
    {
        $this->hasMany(Chat::class);
    }
}
