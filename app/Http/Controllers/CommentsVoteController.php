<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CommentsVote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Jobs\DeleteCommentJob;

class CommentsVoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $commentsvote = CommentsVote::all();

        return response()->json($commentsvote);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }
    public function store(Request $request)
{
    $vote = CommentsVote::where([
        'user_id' => auth()->user()->id,
        'comment_id' => $request->comment_id
    ])->first();

    if (!empty($vote)) {
        if ($vote->type == $request->type) {
            $vote->delete();
            return response()->json(null, 201);
        } else {
            $vote->update(['type' => $request->type]);
        }
    } else {
        $vote = CommentsVote::create([
            'user_id' => auth()->user()->id,
            'comment_id' => $request->comment_id,
            'type' => $request->type,
        ]);
    }

    if ($request->type === 'down') {
        $this->handleDownVote($request->comment_id);
    }

    return response()->json([
        'message' => 'Deletion scheduled successfully.',
    ], 200);
}

private function handleDownVote($commentId)
{
    $latest = CommentsVote::where('comment_id', $commentId)->latest()->get();
    $vote_up = 0;
    $vote_down = 0;
    foreach ($latest as $last) {
        $last->type === 'up' ? $vote_up++ : $vote_down++;
    }

    if ($vote_down != 0 && $vote_up / $vote_down < 1 / 3 && $vote_up / $vote_down != 0) {
        foreach ($latest as $last) {
            $last->delete();
        }
        $comment = Comment::find($commentId);
        if (File::exists(public_path($comment->file))) {
            File::delete(public_path($comment->file));
        }

        $comment->delete();
        DeleteCommentJob::dispatch($commentId)->delay(now()->addSeconds(60));
        return response()->json([
            'message' => 'This Comment has been deleted by our system',

        ]);
    }
}

    // public function store(Request $request)
    // {
    //     $vote = CommentsVote::where([
    //         'user_id' => auth()->user()->id,
    //         'comment_id' => $request->comment_id
    //     ])->first();

    //     if (!empty($vote)) {
    //         if ($vote->type == $request->type) {
    //             $vote->delete();
    //             return response()->json(null, 204);
    //         } else {
    //             $vote->update(['type' => $request->type]);
    //         }
    //     } else {
    //         $vote = CommentsVote::create([
    //             'user_id' => auth()->user()->id,
    //             'comment_id' => $request->comment_id,
    //             'type' => $request->type,
    //         ]);
    //     }

    //     if ($request->type === 'down') {
    //         $this->handleDownVote($request->comment_id);
    //     }

    //     $comment = Comment::find($request->comment_id)->with('vote')->first();

    //     if ($comment->user_id == auth()->user()->id) {
    //         if (File::exists(public_path($comment->file))) {
    //             File::delete(public_path($comment->file));
    //         }
    //         foreach ($comment->vote as $vote) {
    //             $vote->delete();
    //         }
    //         $comment->delete();
    //         return response()->json([
    //             'message' => 'Deleted Successfully',
    //         ]);
    //     }

    //     $comment_id = $request->comment_id;
    //     DeleteCommentJob::dispatch($comment_id)->delay(now()->addSeconds(30));

    //     return response()->json([
    //         'message' => 'Deletion scheduled successfully.',
    //     ], 200);
    // }

    // private function handleDownVote($commentId)
    // {
    //     $latest = CommentsVote::where('comment_id', $commentId)->latest()->get();
    //     $vote_up = 0;
    //     $vote_down = 0;
    //     foreach ($latest as $last) {
    //         $last->type === 'up' ? $vote_up++ : $vote_down++;
    //     }

    //     if ($vote_down !== 0 && $vote_up / $vote_down < 1 / 3 && $vote_up / $vote_down !== 0) {
    //         foreach ($latest as $last) {
    //             $last->delete();
    //         }
    //         $comment = Comment::find($commentId);
    //         if (File::exists(public_path($comment->file))) {
    //             File::delete(public_path($comment->file));
    //         }
    //         $comment->delete();
    //         return response()->json([
    //             'message' => 'This Comment has been deleted by our system',
    //         ]);
    //     }
    // }
    // public function store(Request $request)
    // {
    //     $vote = CommentsVote::where(['user_id' => auth()->user()->id, 'comment_id' => $request->comment_id])->first(); // get vote if available
    //     if (!empty($vote)) { // check if available
    //         if ($vote->type == $request->type) { // check if user trying to remove the vote
    //             $vote->delete();
    //             return response()->json([null, 204]);
    //         } else { // checl if the user wants to change the type of vote
    //             $vote->update(['type' => $request->type]);
    //         }
    //     } else { //if not available

    //         $vote = CommentsVote::create([ // create new vote
    //             'user_id' => auth()->user()->id,
    //             'comment_id' => $request->comment_id,
    //             'type' => $request->type,
    //         ]);
    //     }

    //     if ($request->type == 'down') { // check if the vote is 'down'
    //         $latest = CommentsVote::where('comment_id', $request->comment_id)->latest()->get(); // get votes for that comment
    //         $vote_up = 0;
    //         $vote_down = 0;
    //         foreach ($latest as $last) {
    //             $last->type == 'up' ? $vote_up += 1 : $vote_down += 1;
    //         }

    //         if ($vote_down != 0) {
    //             if ($vote_up / $vote_down < 1 / 3 && $vote_up / $vote_down != 0) { // check the ratio to delete if not qualified to rules
    //                 foreach ($latest as $last) {
    //                     $last->delete();
    //                 }
    //                 $comment = Comment::find($request->comment_id);
    //                 if (File::exists(public_path($comment->file))) {
    //                     File::delete(public_path($comment->file));
    //                 }
    //                 $comment->delete();
    //                 return response()->json([
    //                     'message' => 'This Comment has been deleted by our system',
    //                 ]);
    //             }
    //         }
    //         $comment = Comment::find($request->comment_id)->with('vote')->first();

    //         if ($comment->user_id == auth()->user()->id) {
    //             if (File::exists(public_path($comment->file))) {
    //                 File::delete(public_path($comment->file));
    //             }
    //             foreach ($comment->vote as $vote) {
    //                 $vote->delete();
    //             }
    //             $comment->delete();
    //             return response()->json([
    //                 'message' => 'Deleted Succesfully',
    //             ]);
    //         }

    // }
    // }
}
