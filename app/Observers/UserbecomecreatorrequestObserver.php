<?php

namespace App\Observers;

use App\Models\Userbecomecreatorrequest;

class UserbecomecreatorrequestObserver
{
    /**
     * Handle the Userbecomecreatorrequest "creating" event.
     */
    public function creating(Userbecomecreatorrequest $userbecomecreatorrequest): void
    {
        if (auth()->check()) {
            $userbecomecreatorrequest->requesting_user_id = auth()->id();
        }
    }
}
