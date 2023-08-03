<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comment = Comment::all();

        return response()->json($comment);
    }

    public function store(Request $request)
    {
        $file = null;
        // $text = null;
        if (!empty($request->video)) {
            $file = auth()->user()->id . time() . '.' . $request->video->extension();

            $request->video->move(public_path('tweet/video'), $file);
        } elseif (!empty($request->audio)) {
            $file = auth()->user()->id . time() . '.' . $request->audio->extension();
            $request->audio->move(public_path('tweet/audio'), $file);
        } else {
            $text = $request->text;
    }

        $comment = Comment::create([
            'text' => $text,
            'location' => $request->location,
            'file' => $file,
            'user_id' => auth()->user()->id,
            'tweet_id' => $request->tweet_id,


        ]);

        return response()->json([
            'success' => 'Comment added successfully',
            'comment' => $comment
        ]);
    }

    public function show($id)
    {
        // $comment = Comment::findOrFail($id);

        // return response()->json($comment);
    }

    public function update(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);
        $comment->update($request->all());

        return response()->json($comment);
    }

    public function destroy($id)
    {
        Comment::destroy($id);

        return response()->json(null, 204);
    }
}
