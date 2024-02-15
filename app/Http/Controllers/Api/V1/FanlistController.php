<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Fanlist;
use App\Http\Controllers\Controller;
use App\Http\Resources\FanlistResource;
use App\Http\Requests\StoreFanlistRequest;
use App\Http\Requests\UpdateFanlistRequest;

class FanlistController extends Controller
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
        $fanlist = Fanlist::with([
            'user',
            'fanactivities',
            'fanactivities.fan',
            'fanactivities.creator'
        ])
            ->where('user_id', auth()->user()->id)
            ->latest()
            ->paginate();

        return FanlistResource::collection($fanlist);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFanlistRequest $request)
    {
        $fanlist = Fanlist::create($request->validated());

        return new FanlistResource($fanlist);
    }

    /**
     * Display the specified resource.
     */
    public function show(Fanlist $fanlist)
    {
        return new FanlistResource($fanlist);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFanlistRequest $request, Fanlist $fanlist)
    {
        $fanlist->update($request->validated());

        return new FanlistResource($fanlist);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fanlist $fanlist)
    {
        $fanlist->delete();
    }

    /**
     * Restore the specified deleted resource.
     */
    public function restore(Fanlist $fanlist)
    {
        $fanlist->restore();
    }

    /**
     * Permanently remove the specified resource from storage.
     */
    public function forceDestroy(Fanlist $fanlist)
    {
        $fanlist->forceDelete();
    }
}
