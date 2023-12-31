<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;
use App\Events\NewMessage;


class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function index(Request $request)
     {
     // Retrieve chat messages
     $chats = Chat::with('sender', 'receiver', 'tweet')
     ->where(function ($query) use ($request) {
     $query->where('sender_id', $request->user_id)
     ->orWhere('receiver_id', $request->user_id);
     })
     ->orderBy('created_at')
     ->get();

     return response()->json($chats);
     }

     /**Store a newly created resource in storage.
     */
     public function store(Request $request)
     {
     // Create a new chat message
     $chat = Chat::create([
     'sender_id' => $request->sender_id,
     'receiver_id' => $request->receiver_id,
     'message' => $request->message,
     'tweet_id' => $request->tweet_id,
     ]);

    // Broadcast the new message event
    broadcast(new NewMessage($chat))->toOthers();

    return response()->json($chat, 201);
}

// Get messages from sender to receiver
public function getReceiverMessages(Request $request)
{
    $messages = Chat::where('receiver_id', $request->receiver_id)
    // ->with('sender', 'receiver', 'tweet')
    ->orderBy('created_at')
    ->get();

    return response()->json($messages);
}
// public function sendMessage(Request $request)
// {
//     $sender_id = $request->sender_id;
//     $reveiver_id = $request->reveiver_id;
//     $message = $request->message;
//     $tweetId = $request->tweet_id;

//     $chat = Chat::create([
//         'sender_id' => $sender_id,
//         'receiver_id' => $reveiver_id,
//         'message' => $message,
//         'tweet_id' => $tweetId,
//     ]);

//     return response()->json($chat, 201);
// }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
