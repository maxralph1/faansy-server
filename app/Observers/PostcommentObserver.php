<?php

namespace App\Observers;

use App\Models\Postcomment;

class PostcommentObserver
{
    /**
     * Handle the Postcomment "creating" event.
     */
    public function creating(Postcomment $postcomment): void
    {
        if (auth()->check()) {
            $postcomment->user_id = auth()->id();
        }
    }
}
