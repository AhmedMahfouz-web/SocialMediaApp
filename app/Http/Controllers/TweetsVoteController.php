<?php

namespace App\Http\Controllers;

use App\Jobs\DeleteTweetJob;
use App\Models\Tweet;
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
        // // Create a new vote
        // $request = TweetsVote::create([
        //     'type' => $request->type,
        //     'user_id' => auth()->user()->id,
        //     'tweet_id' => $request->tweet_id,
        // ]);
        // return response()->json([
        //     'success' => 'Comment added successfully',
        //     'tweet_vote' => $request
        // ]);


        $vote = TweetsVote::where(['user_id' => auth()->user()->id, 'tweet_id' => $request->tweet_id])->first(); // get vote if available
        $tweet = Tweet::where('id', $request->tweet_id)->first();
        if (!empty($vote)) { // check if available
            if ($vote->type == $request->type) { // check if user trying to remove the vote
                $vote->delete();

                $tweet->update([
                    'vote_' . $request->type => ['vote_' . $request->type] - 1,
                ]);
                return response()->json(['up', 201]);
            } else { // checl if the user wants to change the type of vote
                $vote->update(['type' => $request->type]);
                if ($request->type == 'up') {
                    $tweet->update([
                        'vote_up' => $tweet->vote_up - 1,
                        'vote_down' => $tweet->vote_down + 1,
                    ]);
                } else {
                    $tweet->update([
                        'vote_up' => $tweet->vote_up + 1,
                        'vote_down' => $tweet->vote_down - 1,
                    ]);
                }
            }
        } else { //if not available
            $vote = TweetsVote::create([ // create new vote
                'user_id' => auth()->user()->id,
                'tweet_id' => $request->tweet_id,
                'type' => $request->type,
            ]);
            $tweet->update([
                'vote_' . $request->type => $tweet['vote_' . $request->type] + 1,
            ]);
        }

        if ($request->type == 'down') { // check if the vote is 'down'
            $latest = TweetsVote::where('Tweet_id', $request->tweet_id)->latest()->get(); // get votes for that comment
            $vote_up = 0;
            $vote_down = 1;
            foreach ($latest as $last) {
                $last->type == 'up' ? $vote_up += 1 : $vote_down += 1;
            }

            if ($vote_down != 0) {
                if ($vote_up / $vote_down < 1 / 3 && $vote_up / $vote_down != 0) { // check the ratio to delete if not qualified to rules

                    DeleteTweetJob::dispatch($request->tweet_id)->delay(now()->addSeconds(60));

                    return response()->json([
                        'message' => 'Deletion scheduled successfully.',
                    ]);
                }
            }
        }

        return response()->json([$request->type, 201]);
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
