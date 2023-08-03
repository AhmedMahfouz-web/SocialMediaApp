<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Http\Request;

class TweetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tweets = Tweet::latest();

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
            'location' => $request->location,
            'file' => $file,
            'user_id' => auth()->user()->id
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
    public function destroy(Tweet $tweet)
    {
        //
    }
}
