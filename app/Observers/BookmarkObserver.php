<?php

namespace App\Observers;

use App\Models\Bookmark;

class BookmarkObserver
{
    /**
     * Handle the Bookmark "creating" event.
     */
    public function creating(Bookmark $bookmark): void
    {
        if (auth()->check()) {
            $bookmark->user_id = auth()->id();
        }
    }
}
