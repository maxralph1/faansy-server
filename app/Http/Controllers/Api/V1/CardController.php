<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Card;
use App\Http\Controllers\Controller;
use App\Http\Resources\CardResource;
use App\Http\Requests\StoreCardRequest;
use App\Http\Requests\UpdateCardRequest;

class CardController extends Controller
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
        $cards = Card::where('user_id', auth()->user()->id)->latest()->paginate();

        return CardResource::collection($cards);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCardRequest $request)
    {
        $card = Card::create($request->validated());

        return new CardResource($card);
    }

    /**
     * Display the specified resource.
     */
    public function show(Card $card)
    {
        return new CardResource($card);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCardRequest $request, Card $card)
    {
        $card->update($request->validated());

        return new CardResource($card);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Card $card)
    {
        $card->delete();
    }

    /**
     * Restore the specified deleted resource.
     */
    public function restore(Card $card)
    {
        $card->restore();
    }

    /**
     * Permanently remove the specified resource from storage.
     */
    public function forceDestroy(Card $card)
    {
        $card->forceDelete();
    }
}
