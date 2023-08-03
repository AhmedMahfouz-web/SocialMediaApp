<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CommentsVote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CommentsVoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $vote = CommentsVote::where(['user_id' => auth()->user()->id, 'comment_id' => $request->comment_id])->first(); // get vote if available
        if (!empty($vote)) { // check if available
            if ($vote->type == $request->type) { // check if user trying to remove the vote
                $vote->delete();
                return response()->json([null, 204]);
            } else { // checl if the user wants to change the type of vote
                $vote->update(['type' => $request->type]);
            }
        } else { //if not available

            $vote = CommentsVote::create([ // create new vote
                'user_id' => auth()->user()->id,
                'comment_id' => $request->comment_id,
                'type' => $request->type,
            ]);
        }

        if ($request->type == 'down') { // check if the vote is 'down'
            $latest = CommentsVote::where('comment_id', $request->comment_id)->latest()->get(); // get votes for that comment
            $vote_up = 0;
            $vote_down = 0;
            foreach ($latest as $last) {
                $last->type == 'up' ? $vote_up += 1 : $vote_down += 1;
            }

            if ($vote_down != 0) {
                if ($vote_up / $vote_down < 1 / 3 && $vote_up / $vote_down != 0) { // check the ratio to delete if not qualified to rules
                    foreach ($latest as $last) {
                        $last->delete();
                    }
                    $comment = Comment::find($request->comment_id);
                    if (File::exists(public_path($comment->file))) {
                        File::delete(public_path($comment->file));
                    }
                    $comment->delete();
                    return response()->json([
                        'message' => 'This Comment has been deleted by our system',
                    ]);
                }
            }
        }

        return response()->json([null, 204]);
    }

    /**
     * Display the specified resource.
     */
    public function show(CommentsVote $commentsVote)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CommentsVote $commentsVote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CommentsVote $commentsVote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CommentsVote $commentsVote)
    {
        //
    }
}
