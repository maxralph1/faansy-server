<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Stream;
use App\Http\Controllers\Controller;
use App\Http\Resources\StreamResource;
use App\Http\Requests\StoreStreamRequest;
use App\Http\Requests\UpdateStreamRequest;

class StreamController extends Controller
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
        $streams = Stream::withTrashed()->latest()->paginate();

        return StreamResource::collection($streams);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStreamRequest $request)
    {
        $stream = Stream::create($request->validated());

        return new StreamResource($stream);
    }

    /**
     * Display the specified resource.
     */
    public function show(Stream $stream)
    {
        return new StreamResource($stream);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStreamRequest $request, Stream $stream)
    {
        $stream->update($request->validated());

        return new StreamResource($stream);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stream $stream)
    {
        $stream->delete();
    }

    /**
     * Restore the specified deleted resource.
     */
    public function restore(Stream $stream)
    {
        $stream->restore();
    }

    /**
     * Permanently remove the specified resource from storage.
     */
    public function forceDestroy(Stream $stream)
    {
        $stream->forceDelete();
    }
}
