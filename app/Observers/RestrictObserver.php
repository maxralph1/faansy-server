<?php

namespace App\Observers;

use App\Models\Restrict;

class RestrictObserver
{
    /**
     * Handle the Restrict "creating" event.
     */
    public function creating(Restrict $restrict): void
    {
        if (auth()->check()) {
            $restrict->restrictor_id = auth()->user()->id;
        }
    }
}
