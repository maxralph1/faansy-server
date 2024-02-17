<?php

namespace App\Observers;

use App\Models\Card;

class CardObserver
{
    /**
     * Handle the Card "creating" event.
     */
    public function creating(Card $card): void
    {
        if (auth()->check()) {
            $card->user_id = auth()->id();
        }
    }
}
