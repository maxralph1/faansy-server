<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Pollresponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\PollresponseResource;
use App\Http\Requests\StorePollresponseRequest;
use App\Http\Requests\UpdatePollresponseRequest;

class PollresponseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pollresponses = Pollresponse::latest()->paginate();

        return PollresponseResource::collection($pollresponses);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePollresponseRequest $request)
    {
        $pollresponse = Pollresponse::create($request->validated());

        return new PollresponseResource($pollresponse);
    }

    /**
     * Display the specified resource.
     */
    public function show(Pollresponse $pollresponse)
    {
        return new PollresponseResource($pollresponse);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePollresponseRequest $request, Pollresponse $pollresponse)
    {
        $pollresponse->update($request->validated());

        return new PollresponseResource($pollresponse);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pollresponse $pollresponse)
    {
        $pollresponse->delete();
    }

    /**
     * Restore the specified deleted resource.
     */
    public function restore(Pollresponse $pollresponse)
    {
        $pollresponse->restore();
    }

    /**
     * Permanently remove the specified resource from storage.
     */
    public function forceDestroy(Pollresponse $pollresponse)
    {
        $pollresponse->forceDelete();
    }
}
