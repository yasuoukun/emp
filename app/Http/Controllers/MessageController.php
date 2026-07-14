<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Events\MessageSent;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();
        $query = Message::query();
        
        if (in_array(auth()->user()->role, ['admin', 'super_admin']) && $request->has('user_id')) {
            $otherUserId = $request->user_id;
            $query->where(function ($q) use ($otherUserId) {
                $q->where('sender_id', $otherUserId)
                  ->orWhere('receiver_id', $otherUserId);
            });
            // Mark customer messages to admin as read
            Message::where('sender_id', $otherUserId)
                ->whereNull('receiver_id')
                ->where('is_read', false)
                ->update(['is_read' => true]);
        } else {
            $query->where('sender_id', $userId)->orWhere('receiver_id', $userId);
            // Mark admin messages to customer as read only when read parameter is 1
            if ($request->input('read') == 1) {
                Message::where('receiver_id', $userId)
                    ->where('is_read', false)
                    ->update(['is_read' => true]);
            }
        }
        
        $messages = $query->with('sender')->orderBy('created_at', 'asc')->get();
        return response()->json($messages);
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'receiver_id' => 'nullable|integer'
        ]);

        $message = Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id, // Null means it's sent to admin group
            'content' => $request->content,
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json($message);
    }
}
