<?php

namespace App\Observers;

use App\Models\Chat;
use App\Http\Requests\StoreChatRequest;

class ChatObserver
{
    /**
     * Handle the Chat "creating" event.
     */
    public function creating(Chat $chat): void
    {
        // $chat_exists = Chat::where([
        //     'participator_1_id', $chat->participator_1_id,
        //     'participator_2_id', $chat->participator_2_id,
        // ])
        //     ->orWhere([
        //         'participator_1_id', $chat->participator_2_id,
        //         'participator_2_id', $chat->participator_1_id,
        //     ])->first();

        // $chat_exists && abort(409);

        $chat->slug = str()->slug($chat->participator_1_id . '_' . $chat->participator_2_id);
    }

    /**
     * Handle the Chat "created" event.
     */
    public function created(Chat $chat): void
    {
        //
    }

    /**
     * Handle the Chat "updated" event.
     */
    public function updated(Chat $chat): void
    {
        //
    }

    /**
     * Handle the Chat "deleted" event.
     */
    public function deleted(Chat $chat): void
    {
        //
    }

    /**
     * Handle the Chat "restored" event.
     */
    public function restored(Chat $chat): void
    {
        //
    }

    /**
     * Handle the Chat "force deleted" event.
     */
    public function forceDeleted(Chat $chat): void
    {
        //
    }
}
