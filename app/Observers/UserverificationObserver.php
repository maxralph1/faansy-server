<?php

namespace App\Observers;

use App\Models\Userverification;

class UserverificationObserver
{
    /**
     * Handle the Userverification "creating" event.
     */
    public function creating(Userverification $userverification): void
    {
        if (auth()->check()) {
            $userverification->requesting_user_id = auth()->id();
        }
    }
}
