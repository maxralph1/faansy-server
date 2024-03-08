<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Block;
use App\Http\Controllers\Controller;
use App\Http\Resources\BlockResource;
use App\Http\Requests\StoreBlockRequest;
use App\Http\Requests\UpdateBlockRequest;

class BlockController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blocks = Block::with([
            'blocker',
            'blocked',
        ])->where('blocker_id', auth()->id)->latest()->paginate();

        return BlockResource::collection($blocks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlockRequest $request)
    {
        $already_blocked = Block::where([
            'blocker_id' => auth()->user()->id,
            'blocked_id' => $request->blocked_id,
        ])->first();

        if ($already_blocked) {
            return response()->json([
                'status' => 'error',
                'message' => 'Conflict: Already Blocked!',
            ], 409);
            // abort('409', 'Conflict: Already Blocked!');
        }

        $block = Block::create($request->validated());

        return new BlockResource($block);
    }

    /**
     * Display the specified resource.
     */
    public function show(Block $block)
    {
        return new BlockResource($block);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlockRequest $request, Block $block)
    {
        $block->update($request->validated());

        return new BlockResource($block);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Block $block)
    {
        $block->delete();
    }

    /**
     * Restore the specified deleted resource.
     */
    public function restore(Block $block)
    {
        $block->restore();
        // $block->restoreQuietly();
    }

    /**
     * Permanently remove the specified resource from storage.
     */
    public function forceDestroy(Block $block)
    {
        $block->forceDelete();
    }
}
