<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Wallet;
use App\Http\Controllers\Controller;
use App\Http\Resources\WalletResource;
use App\Http\Requests\StoreWalletRequest;
use App\Http\Requests\UpdateWalletRequest;

class WalletController extends Controller
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
        $wallets = Wallet::withTrashed()
            ->latest()
            ->paginate();

        return WalletResource::collection($wallets);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWalletRequest $request)
    {
        $wallet = Wallet::create($request->validated());

        return new WalletResource($wallet);
    }

    /**
     * Display the specified resource.
     */
    public function show(Wallet $wallet)
    {
        return new WalletResource($wallet);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWalletRequest $request, Wallet $wallet)
    {
        $wallet->update($request->validated());

        return new WalletResource($wallet);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Wallet $wallet)
    {
        $wallet->delete();
    }

    /**
     * Restore the specified deleted resource.
     */
    public function restore(Wallet $wallet)
    {
        $wallet->restore();
    }

    /**
     * Permanently remove the specified resource from storage.
     */
    public function forceDestroy(Wallet $wallet)
    {
        $wallet->forceDelete();
    }


    /**
     * Additional Methods
     */

    /**
     * Display a listing of the resource.
     */
    public function myWallet()
    {
        $wallet = Wallet::where('user_id', auth()->id)
            ->latest()
            ->paginate();

        return WalletResource::collection($wallet);
    }
}
