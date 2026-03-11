<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSentEvent implements ShouldBroadcastNow {

    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $recipientId;
    public array $message;

    public function __construct(Message $message) {
        $this->recipientId = (int) $message->recipient;

        $this->message = [
            'id' => $message->id,
            'message' => $message->message,
            'recipient' => $message->recipient,
            'created_at' => $message->created_at?->toDateTimeString(),
            'sender' => [
                'id' => (int) $message->sender()->value('id'),
                'name' => $message->sender()->value('name') ?? null,
            ]
        ];
    }

    public function broadcastOn(): array {
        return [
            new PrivateChannel('chat.'.$this->recipientId),
        ];
    }

    public function broadcastAs(): string {
        return 'message.sent';
    }
}
