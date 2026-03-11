<?php

namespace App\Http\Controllers;

use App\Events\MessageSentEvent;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller{
    public function index()
    {
        $me = Auth::user();

        $users = User::query()
            ->select('id', 'name', 'email')
            ->where('id', '!=', $me->id)
            ->orderBy('name')
            ->get();

        return view('chat.index', compact('users', 'me'));
    }

    public function messages(User $user): JsonResponse {
        $meId = Auth::id();

        $messages = Message::query()
            ->with('sender:id,name')
            ->where(function ($q) use ($meId, $user) {
                $q->where('sender', $meId)->where('recipient', $user->id);
            })
            ->orWhere(function ($q) use ($meId, $user) {
                $q->where('sender', $user->id)->where('recipient', $meId);
            })
            ->orderBy('created_at')
            ->get();

        return response()->json($messages);
    }

    public function store(Request $request): JsonResponse {
        $data = $request->validate([
            'recipient' => ['required', 'exists:users,id'],
            'message' => ['required', 'string', 'max:1000'],
        ]);

        $message = Message::create([
            'sender' => Auth::id(),
            'recipient' => (int) $data['recipient'],
            'message' => $data['message'],
        ])->load('sender:id,name');

        broadcast(new MessageSentEvent($message))->toOthers();

        return response()->json($message,201);
    }
}
