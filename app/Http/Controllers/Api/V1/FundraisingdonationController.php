<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Fundraisingdonation;
use App\Http\Controllers\Controller;
use App\Http\Resources\FundraisingdonationResource;
use App\Http\Requests\StoreFundraisingdonationRequest;
use App\Http\Requests\UpdateFundraisingdonationRequest;

class FundraisingdonationController extends Controller
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
        $fundraisingdonations = Fundraisingdonation::with([
            'fundraising',
            'fundraising.wallet',
            'fundraising.wallet.user',
            'user'
        ])->latest()->paginate();

        return FundraisingdonationResource::collection($fundraisingdonations);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFundraisingdonationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Fundraisingdonation $fundraisingdonation)
    {
        return new FundraisingdonationResource($fundraisingdonation);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFundraisingdonationRequest $request, Fundraisingdonation $fundraisingdonation)
    {
        $fundraisingdonation->update($request->validated());

        return new FundraisingdonationResource($fundraisingdonation);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fundraisingdonation $fundraisingdonation)
    {
        $fundraisingdonation->delete();
    }

    /**
     * Restore the specified deleted resource.
     */
    public function restore(Fundraisingdonation $fundraisingdonation)
    {
        $fundraisingdonation->restore();
    }

    /**
     * Permanently remove the specified resource from storage.
     */
    public function forceDestroy(Fundraisingdonation $fundraisingdonation)
    {
        $fundraisingdonation->forceDelete();
    }
}
