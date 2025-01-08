<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use App\Models\User;

class MessageController extends Controller
{
    public function index($receiverId)
{
    $userId = auth()->id();

    // Fetch the receiver user
    $receiver = User::findOrFail($receiverId);

    // Fetch messages between the logged-in user and the receiver
    $messages = Message::where(function ($query) use ($receiverId, $userId) {
            $query->where('sender_id', $userId)
                  ->where('receiver_id', $receiverId);
        })
        ->orWhere(function ($query) use ($receiverId, $userId) {
            $query->where('sender_id', $receiverId)
                  ->where('receiver_id', $userId);
        })
        ->orderBy('created_at', 'asc')
        ->get();

    // Pass a flag to distinguish between chat list and specific chat
    return view('messages', [
        'chats' => [],
        'receiver' => $receiver,
        'messages' => $messages,
    ]);
}


    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        return redirect()->route('messages.chat', ['receiver' => $request->receiver_id]);
    }

    public function chatList()
{
    $userId = auth()->id();

    // Group messages by unique chat participants
    $chats = Message::where('sender_id', $userId)
        ->orWhere('receiver_id', $userId)
        ->with(['sender:id,name,profile_picture', 'receiver:id,name,profile_picture'])
        ->get()
        ->groupBy(function ($message) use ($userId) {
            return $message->sender_id === $userId ? $message->receiver_id : $message->sender_id;
        });

    // Render the existing messages.blade.php
    return view('messages', compact('chats'));
}

}
