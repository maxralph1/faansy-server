<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Poll;
use App\Http\Controllers\Controller;
use App\Http\Resources\PollResource;
use App\Http\Requests\StorePollRequest;
use App\Http\Requests\UpdatePollRequest;

class PollController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $polls = Poll::latest()->paginate();

        return PollResource::collection($polls);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePollRequest $request)
    {
        $poll = Poll::create($request->validated());

        return new PollResource($poll);
    }

    /**
     * Display the specified resource.
     */
    public function show(Poll $poll)
    {
        return new PollResource($poll);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePollRequest $request, Poll $poll)
    {
        $poll->update($request->validated());

        return new PollResource($poll);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Poll $poll)
    {
        $poll->delete();
    }

    /**
     * Restore the specified deleted resource.
     */
    public function restore(Poll $poll)
    {
        $poll->restore();
    }

    /**
     * Permanently remove the specified resource from storage.
     */
    public function forceDestroy(Poll $poll)
    {
        $poll->forceDelete();
    }
}
