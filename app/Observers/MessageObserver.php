<?php

namespace App\Observers;

use App\Models\Message;

class MessageObserver
{
    /**
     * Handle the Message "creating" event.
     */
    public function creating(Message $message): void
    {
        if (auth()->check()) {
            $message->user_id = auth()->user()->id;
        }
    }

    /**
     * Handle the Message "created" event.
     */
    public function created(Message $message): void
    {
        //
    }

    /**
     * Handle the Message "updated" event.
     */
    public function updated(Message $message): void
    {
        //
    }

    /**
     * Handle the Message "deleted" event.
     */
    public function deleted(Message $message): void
    {
        //
    }

    /**
     * Handle the Message "restored" event.
     */
    public function restored(Message $message): void
    {
        //
    }

    /**
     * Handle the Message "force deleted" event.
     */
    public function forceDeleted(Message $message): void
    {
        //
    }
}
