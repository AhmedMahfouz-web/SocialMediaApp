<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Tweet;
use App\Models\TweetsVote;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Contracts\Service\Attribute\Required;

class TweetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $haversine = "(
    6371 * acos(
        cos(radians(" . $request->latitude . "))
        * cos(radians(`latitude`))
        * cos(radians(`longitude`) - radians(" . $request->longitude . "))
        + sin(radians(" . $request->latitude . ")) * sin(radians(`latitude`))
    )
)";
        $tweets = Tweet::select('*')
           ->where('country', $request->country)
            ->where(function($query)use($request)){
                if(!empty(request->hashtag)){
                     $query->where('hashtags','like','%'.$request->hashtag .'%');
                }
                if(!empty($request->user)){
                    $query->where('user_id',$request->user);
                }
            })
            ->selectRaw("$haversine AS distance")
            ->latest()
            ->orderby("created_at", "desc")
            // ->groupby('id')  
            ->get();

        return response()->json([
            'tweets' => $tweets,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $file = null;
        $text = null;
        if (!empty($request->video)) {
            $file = auth()->user()->id . time() . '.' . $request->video->extension();
            $request->video->move(public_path('tweet/video'), $file);
        } elseif (!empty($request->audio)) {
            $file = auth()->user()->id . time() . '.' . $request->audio->extension();
            $request->audio->move(public_path('tweet/audio'), $file);
        } else {
            $text = $request->text;
        }

        $tweet = Tweet::create([
            'text' => $text,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'country' => $request->country,
            'file' => $file,
            'color' => $request->color,
            'user_id' => auth()->user()->id,
        ]);

        return response()->json([
            'success' => 'Tweet added successfully',
            'tweet' => $tweet
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tweet $tweet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tweet $tweet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tweet $tweet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $tweet = Tweet::findOrFail($request->id);

        if ($request->ban == null) {
            // Check if the tweet belongs to the authenticated user
            if ($tweet->user_id !== auth()->user()->id) {
                return response()->json([
                    'error' => 'Unauthorized',
                ], 401);
            }
        }

        // Delete the associated file (if any)
        $file = $tweet->file;
        if (!empty($file)) {
            $filePath = public_path('tweet/video/' . $file);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        //Get Votes and Delete it.
        $votes = TweetsVote::where('tweet_id', $tweet->id)->get();
        foreach ($votes as $vote) {
            $vote->delete();
        }

        // Get Comments with Their Votes and Delete them all and Delete file (if any).
        $comments = Comment::where('tweet_id', $tweet->id)->with('votes')->get();
        if (!empty($comments)) {
            foreach ($comments as $comment) {
                //Delete file (if any).
                $commentFile = $comment->file;
                if (!empty($commentFile)) {
                    $filePath = public_path('tweet/video/' . $file);
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                }

                // Delete Comments votes.
                foreach ($comment->votes as $vote) {
                    $vote->delete();
                }

                $comment->delete();
            }
        }
        // Delete the tweet
        $tweet->delete();

        if ($request->ban == null) {
            return response()->json([
                'success' => 'Tweet deleted successfully',
            ]);
        }
    }

    public function destroy_and_ban(Request $request)
    {
        $user_id = Tweet::select('user_id')->where('id', $request->id)->first();
        $user = User::find($user_id->user_id);
        $votes = TweetsVote::where('tweet_id', $request->id)->get();
        $vote_up = 0;
        $vote_down = 0;
        foreach ($votes as $vote) {
            $vote->type == 'up' ? $vote_up += 1 : $vote_down += 1;
        }
        if ($vote_down != 0) {
            if ($vote_up / $vote_down < 1 / 3 && $vote_up / $vote_down != 0 || $vote_up == 0 && $vote_down > 2) {

                $deleted = $this->destroy($request);
                DB::table('ban_user')->insert([
                    'user_id' => $user_id->user_id,
                    'created_at' => now(),
                ]);
            }
        } else {
            return response()->json('faild');
        }

        $bans = DB::table('ban_user')->where('user_id', $user_id->user_id)->get();
        $ban_today = 0;
        foreach ($bans as $ban) {
            $date = Carbon::parse($ban->created_at);
            $currentDate = Carbon::now();

            $diff = $date->diffInDays($currentDate);

            if ($diff <= 0) {
                $ban_today = $ban_today + 1;
            }
        };

        if ($ban_today >= 7) {
            if ($user->ban == 0) {
                $ban = 1;
                $ban_date = Carbon::now()->addDays(7);
            } elseif ($user->ban == 1) {
                $ban = 2;
                $ban_date = Carbon::now()->addDays(30);
            } elseif ($user->ban == 2) {
                $ban = 3;
                $ban_date = Carbon::now()->addDays(30000);
            }
            $user->update([
                'ban' => $ban,
                'ban_end' => $ban_date,
            ]);
        }

        return response()->json(['Success' => 'User is listed on ban users'], 201);
    }
}
