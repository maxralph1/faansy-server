<?php

namespace App\Observers;

use App\Models\Tip;
use App\Models\Transaction;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;

class TipObserver
{
    /**
     * Handle the Tip "creating" event.
     */
    public function creating(Tip $tip): void
    {
        // DB::transaction(function () use ($tip) {
        //     Transaction::create([
        //         'recipient_id' => $tip->recipient_id,
        //         'donor_id' => $tip->donor_id,
        //         'transaction_type' => 'tip',
        //         'amount' => $tip->amount,
        //     ]);

        //     Notification::create([
        //         'user_id' => $tip->recipient_id,
        //         'title' => 'Tip Notification',
        //         'body' => 'You have received a tip of $' . $tip->amount . ' from' . $tip->donor->first_name . ' ' . $tip->donor->last_name . '.',
        //     ]);
        // });
        if (auth()->check()) {
            $tip->donor_id = auth()->user()->id;
        }
    }

    /**
     * Handle the Tip "created" event.
     */
    public function created(Tip $tip): void
    {
        //
    }

    /**
     * Handle the Tip "updated" event.
     */
    public function updated(Tip $tip): void
    {
        //
    }

    /**
     * Handle the Tip "deleted" event.
     */
    public function deleted(Tip $tip): void
    {
        //
    }

    /**
     * Handle the Tip "restored" event.
     */
    public function restored(Tip $tip): void
    {
        //
    }

    /**
     * Handle the Tip "force deleted" event.
     */
    public function forceDeleted(Tip $tip): void
    {
        //
    }
}
