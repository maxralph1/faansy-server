<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Block;
use App\Http\Requests\StoreBlockRequest;

class BlockObserver
{
    /**
     * Handle the Block "creating" event.
     */
    public function creating(StoreBlockRequest $request, Block $block): void
    {
        if (auth()->check()) {
            $user = User::where('id', auth()->user()->id)->first();

            $creator_role = auth()->user()->role()->where('title', 'creator')->first();

            // !auth()->user()->role()->where('title', $role)->exists()

            if (!$creator_role) {
                $block->blocker_id = auth()->id();
            } else {
                $block->blocker_id = $request->blocker_id;
            }
        }
    }

    /**
     * Handle the Block "created" event.
     */
    public function created(Block $block): void
    {
        //
    }

    /**
     * Handle the Block "updating" event.
     */
    public function updating(Block $block): void
    {
        //
    }

    /**
     * Handle the Block "updated" event.
     */
    public function updated(Block $block): void
    {
        //
    }

    /**
     * Handle the Block "deleted" event.
     */
    public function deleted(Block $block): void
    {
        //
    }

    /**
     * Handle the Block "restored" event.
     */
    public function restored(Block $block): void
    {
        //
    }

    /**
     * Handle the Block "force deleted" event.
     */
    public function forceDeleted(Block $block): void
    {
        //
    }
}
