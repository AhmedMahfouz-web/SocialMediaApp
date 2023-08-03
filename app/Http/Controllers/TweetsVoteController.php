<?php

namespace App\Http\Controllers;

use App\Models\TweetsVote;
use Illuminate\Http\Request;

class TweetsVoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve all votes
        $votes = TweetsVote::all();
        return response()->json($votes);
    }

    public function show($id)
    {
        // Retrieve a specific vote
        $vote = TweetsVote::find($id);
        return response()->json($vote);
    }
    public function store(Request $request)
    {
        // Create a new vote
        $request = TweetsVote::create([
            'type' => $request->type,
            'user_id' => auth()->user()->id,
            'tweet_id' => $request->tweet_id,
        ]);
        return response()->json([
            'success' => 'Comment added successfully',
            'tweet_vote' => $request
        ]);
    }
    public function update(Request $request, $id)
    {
        // Update an existing vote
        $vote = TweetsVote::find($id);
        $vote->update($request->all());
        return response()->json($vote);
    }

    public function destroy($id)
    {
        // Delete a vote
        $vote = TweetsVote::find($id);
        $vote->delete();
        return response()->json(null, 204);
    }
}
