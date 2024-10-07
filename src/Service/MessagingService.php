<?php

namespace App\Services;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\User;

class MessagingService
{
    /**
     * Send a message to a user.
     *
     * @param User $sender
     * @param User $recipient
     * @param string $content
     *
     * @return Message
     */
    public function sendMessage(User $sender, User $recipient, string $content): Message
    {
        $message = Message::create([
            'sender_id' => $sender->id,
            'recipient_id' => $recipient->id,
            'content' => $content,
        ]);

        // Trigger event to notify the recipient about the new message
        event(new MessageSent($message));

        return $message;
    }

    /**
     * Get messages for a user.
     *
     * @param User $user
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getMessagesForUser(User $user): \Illuminate\Database\Eloquent\Collection
    {
        return Message::where('recipient_id', $user->id)
            ->orWhere('sender_id', $user->id)
            ->orderBy('created_at', 'asc')
            ->get();
    }
}
