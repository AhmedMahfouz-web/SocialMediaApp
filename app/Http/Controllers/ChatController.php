<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   
    public function index(Request $request)
    {
       // Retrieve chat messages
       $chats = Chat::with('sender', 'reveiver', 'tweet')
       ->where(function ($query) use ($request) {
           $query->where('sender_id', $request->user_id)
               ->orWhere('reveiver_id', $request->user_id);
       })
       ->orderBy('created_at')
       ->get();

   return response()->json($chats);
}
     /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Create a new chat message
        $chat = Chat::create([
            'sender_id' => $request->sender_id,
            'reveiver_id' => $request->reveiver_id,
            'message' => $request->message,
            'tweet_id' => $request->tweet_id,
        ]);

        return response()->json($chat, 201);
    }

    //Get message from sender to reciver
    public function getReceiverMessages(Request $request)
{
    $receiverId = $request->receiver_id;

    $messages = Chat::where('reveiver_id', $receiverId)
        // ->with('sender', 'receiver', 'tweet')
        ->orderBy('created_at')
        ->get();

    return response()->json($messages);
}
    /**
     * Display the specified resource.
     */
    public function show(Chat $chat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chat $chat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chat $chat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chat $chat)
    {
        //
    }
}
