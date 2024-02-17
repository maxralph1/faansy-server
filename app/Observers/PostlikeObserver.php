<?php

namespace App\Observers;

use App\Models\Postlike;

class PostlikeObserver
{
    /**
     * Handle the Postlike "creating" event.
     */
    public function creating(Postlike $postlike): void
    {
        if (auth()->check()) {
            $postlike->user_id = auth()->id();
        }
    }
}
