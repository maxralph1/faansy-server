<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Fundwithdrawal;
use App\Http\Controllers\Controller;
use App\Http\Resources\FundwithdrawalResource;
use App\Http\Requests\StoreFundwithdrawalRequest;
use App\Http\Requests\UpdateFundwithdrawalRequest;

class FundwithdrawalController extends Controller
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
        $fundwithdrawal = Fundwithdrawal::with([
            'wallet',
            'wallet.user',
            'user'
        ])->where('user_id', auth()->user()->id)
            ->latest()
            ->paginate();

        return FundwithdrawalResource::collection($fundwithdrawal);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFundwithdrawalRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Fundwithdrawal $fundwithdrawal)
    {
        return new FundwithdrawalResource($fundwithdrawal);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFundwithdrawalRequest $request, Fundwithdrawal $fundwithdrawal)
    {
        $fundwithdrawal->update($request->validated());

        return new FundwithdrawalResource($fundwithdrawal);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fundwithdrawal $fundwithdrawal)
    {
        $fundwithdrawal->delete();
    }

    /**
     * Restore the specified deleted resource.
     */
    public function restore(Fundwithdrawal $fundwithdrawal)
    {
        $fundwithdrawal->restore();
    }

    /**
     * Permanently remove the specified resource from storage.
     */
    public function forceDestroy(Fundwithdrawal $fundwithdrawal)
    {
        $fundwithdrawal->forceDelete();
    }
}
