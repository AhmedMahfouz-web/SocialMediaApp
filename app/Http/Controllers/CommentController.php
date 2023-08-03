<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CommentController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $comment = Comment::find($request->comment_id)->with('vote')->first();

        if ($comment->user_id == auth()->user()->id) {
            if (File::exists(public_path($comment->file))) {
                File::delete(public_path($comment->file));
            }
            foreach ($comment->vote as $vote) {
                $vote->delete();
            }
            $comment->delete();
            return response()->json([
                'message' => 'Deleted Succesfully',
            ]);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
