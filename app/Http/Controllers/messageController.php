<?php

namespace App\Http\Controllers;

use App\Models\message;
use Illuminate\Http\Request;

class messageController extends Controller {

    public function index() {
        return message::all();
    }

    public function store(Request $request) {
        $data = $request->validate([
            'message' => ['required'],
            'from'    => ['required', 'exists:users'],
            'to'      => ['required', 'exists:users'],
        ]);

        return message::create($data);
    }

    public function show(message $message) {
        return $message;
    }

    public function update(Request $request, message $message) {
        $data = $request->validate([
            'message' => ['required'],
            'from'    => ['required', 'exists:users'],
            'to'      => ['required', 'exists:users'],
        ]);

        $message->update($data);

        return $message;
    }

    public function destroy(message $message) {
        $message->delete();

        return response()->json();
    }
}
