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
        //
    }

    /**
     * Handle the Bookmark "created" event.
     */
    public function created(Bookmark $bookmark): void
    {
        //
    }

    /**
     * Handle the Bookmark "updated" event.
     */
    public function updated(Bookmark $bookmark): void
    {
        //
    }

    /**
     * Handle the Bookmark "deleted" event.
     */
    public function deleted(Bookmark $bookmark): void
    {
        //
    }

    /**
     * Handle the Bookmark "restored" event.
     */
    public function restored(Bookmark $bookmark): void
    {
        //
    }

    /**
     * Handle the Bookmark "force deleted" event.
     */
    public function forceDeleted(Bookmark $bookmark): void
    {
        //
    }
}
