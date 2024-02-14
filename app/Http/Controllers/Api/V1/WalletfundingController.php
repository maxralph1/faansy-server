<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Walletfunding;
use App\Http\Controllers\Controller;
use App\Http\Resources\WalletfundingResource;
use App\Http\Requests\StoreWalletfundingRequest;
use App\Http\Requests\UpdateWalletfundingRequest;

class WalletfundingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $walletfundings = Walletfunding::withTrashed()
            ->latest()
            ->paginate();

        return WalletfundingResource::collection($walletfundings);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWalletfundingRequest $request)
    {
        $walletfunding = Walletfunding::create($request->validated());

        return new WalletfundingResource($walletfunding);
    }

    /**
     * Display the specified resource.
     */
    public function show(Walletfunding $walletfunding)
    {
        return new WalletfundingResource($walletfunding);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWalletfundingRequest $request, Walletfunding $walletfunding)
    {
        $walletfunding->update($request->validated());

        return new WalletfundingResource($walletfunding);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Walletfunding $walletfunding)
    {
        $walletfunding->delete();
    }

    /**
     * Restore the specified deleted resource.
     */
    public function restore(Walletfunding $walletfunding)
    {
        $walletfunding->restore();
    }

    /**
     * Permanently remove the specified resource from storage.
     */
    public function forceDestroy(Walletfunding $walletfunding)
    {
        $walletfunding->forceDelete();
    }


    /**
     * Additional Methods
     */

    /**
     * Display a listing of the resource.
     */
    public function myWalletfunding()
    {
        $walletfunding = Walletfunding::where('user_id', auth()->id)
            ->latest()
            ->paginate();

        return WalletfundingResource::collection($walletfunding);
    }
}
