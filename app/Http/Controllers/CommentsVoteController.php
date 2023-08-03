<?php

namespace App\Http\Controllers;

use App\Models\CommentsVote;
use Illuminate\Http\Request;

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

    public function store(Request $request)
    {
        $commentsvote = CommentsVote::create($request->all());

        return response()->json($commentsvote, 201);
    }

    public function show($id)
    {
        $commentsvote = CommentsVote::findOrFail($id);

        return response()->json($commentsvote);
    }

    public function update(Request $request, $id)
    {
        $commentsvote = CommentsVote::findOrFail($id);
        $commentsvote->update($request->all());

        return response()->json($commentsvote);
    }

    public function destroy($id)
    {
        CommentsVote::destroy($id);

        return response()->json(null, 204);
    }
}
