<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller {

    public function index() {
        return Message::all();
    }

    public function store(Request $request) {
        $data = $request->validate([
            'message' => ['required'],
            'from'    => ['required', 'exists:users'],
            'to'      => ['required', 'exists:users'],
        ]);

        return Message::create($data);
    }

    public function show(Message $message) {
        return $message;
    }

    public function update(Request $request, Message $message) {
        $data = $request->validate([
            'message' => ['required'],
            'from'    => ['required', 'exists:users'],
            'to'      => ['required', 'exists:users'],
        ]);

        $message->update($data);

        return $message;
    }

    public function destroy(Message $message) {
        $message->delete();

        return response()->json();
    }
}
