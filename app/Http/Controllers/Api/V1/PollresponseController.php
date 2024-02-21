<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Poll;
use App\Models\Polloption;
use App\Models\Pollresponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\PollresponseResource;
use App\Http\Requests\StorePollresponseRequest;
use App\Http\Requests\UpdatePollresponseRequest;

class PollresponseController extends Controller
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
        $pollresponses = Pollresponse::with([
            'poll',
            'poll.user',
            'polloption',
            'polloption.poll',
            'polloption.user',
            'user'
        ])->latest()->paginate();

        return PollresponseResource::collection($pollresponses);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePollresponseRequest $request)
    {
        $validated = $request->validated();

        $pollresponse_exists = Pollresponse::where([
            'poll_id' => $validated['poll_id'],
            'user_id' => auth()->user()->id
        ])->first();

        if (!$pollresponse_exists) {
            $pollresponse = Pollresponse::create([
                'polloption_id' => $validated['polloption_id'],
                'poll_id' => $validated['poll_id'],
                'user_id' => auth()->user()->id,
                'text_response' => ''
                // ($request->text_response) && 'text_response' => $validated['text_response']
            ]);

            return new PollresponseResource($pollresponse);
        } elseif ($pollresponse_exists) {
            $pollresponse_exists->delete();
        }
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
