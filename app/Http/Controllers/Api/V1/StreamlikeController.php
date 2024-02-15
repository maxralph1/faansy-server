<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Streamlike;
use App\Http\Controllers\Controller;
use App\Http\Resources\StreamlikeResource;
use App\Http\Requests\StoreStreamlikeRequest;
use App\Http\Requests\UpdateStreamlikeRequest;

class StreamlikeController extends Controller
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
        $streamlikes = Streamlike::withTrashed()->latest()->paginate();

        return StreamlikeResource::collection($streamlikes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStreamlikeRequest $request)
    {
        $streamlike = Streamlike::create($request->validated());

        return new StreamlikeResource($streamlike);
    }

    /**
     * Display the specified resource.
     */
    public function show(Streamlike $streamlike)
    {
        return new StreamlikeResource($streamlike);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStreamlikeRequest $request, Streamlike $streamlike)
    {
        $streamlike->update($request->validated());

        return new StreamlikeResource($streamlike);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Streamlike $streamlike)
    {
        $streamlike->delete();
    }

    /**
     * Restore the specified deleted resource.
     */
    public function restore(Streamlike $streamlike)
    {
        $streamlike->restore();
    }

    /**
     * Permanently remove the specified resource from storage.
     */
    public function forceDestroy(Streamlike $streamlike)
    {
        $streamlike->forceDelete();
    }
}
