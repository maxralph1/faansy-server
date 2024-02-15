<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Fundraising;
use App\Http\Controllers\Controller;
use App\Http\Resources\FundraisingResource;
use App\Http\Requests\StoreFundraisingRequest;
use App\Http\Requests\UpdateFundraisingRequest;

class FundraisingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fundraisings = Fundraising::with([
            'wallet',
            'wallet.user',
            'user'
        ])->latest()->paginate();

        return FundraisingResource::collection($fundraisings);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFundraisingRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Fundraising $fundraising)
    {
        return new FundraisingResource($fundraising);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFundraisingRequest $request, Fundraising $fundraising)
    {
        $fundraising->update($request->validated());

        return new FundraisingResource($fundraising);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fundraising $fundraising)
    {
        $fundraising->delete();
    }

    /**
     * Restore the specified deleted resource.
     */
    public function restore(Fundraising $fundraising)
    {
        $fundraising->restore();
    }

    /**
     * Permanently remove the specified resource from storage.
     */
    public function forceDestroy(Fundraising $fundraising)
    {
        $fundraising->forceDelete();
    }
}
