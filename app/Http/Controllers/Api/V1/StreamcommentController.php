<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Streamcomment;
use App\Http\Controllers\Controller;
use App\Http\Resources\StreamcommentResource;
use App\Http\Requests\StoreStreamcommentRequest;
use App\Http\Requests\UpdateStreamcommentRequest;

class StreamcommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $streamcomments = Streamcomment::withTrashed()->latest()->paginate();

        return StreamcommentResource::collection($streamcomments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStreamcommentRequest $request)
    {
        $streamcomment = Streamcomment::create($request->validated());

        return new StreamcommentResource($streamcomment);
    }

    /**
     * Display the specified resource.
     */
    public function show(Streamcomment $streamcomment)
    {
        return new StreamcommentResource($streamcomment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStreamcommentRequest $request, Streamcomment $streamcomment)
    {
        $streamcomment->update($request->validated());

        return new StreamcommentResource($streamcomment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Streamcomment $streamcomment)
    {
        $streamcomment->delete();
    }

    /**
     * Restore the specified deleted resource.
     */
    public function restore(Streamcomment $streamcomment)
    {
        $streamcomment->restore();
    }

    /**
     * Permanently remove the specified resource from storage.
     */
    public function forceDestroy(Streamcomment $streamcomment)
    {
        $streamcomment->forceDelete();
    }
}
