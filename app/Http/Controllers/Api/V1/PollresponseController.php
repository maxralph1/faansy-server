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

        $pollresponse = new Pollresponse();

        $poll_exists = Poll::find($validated['poll_id']);
        $polloption_exists = Polloption::find($validated['polloption_id']);

        Pollresponse::create([
            $pollresponse['poll_id'] = $poll_exists->id,
            $pollresponse['user_id'] = auth()->user()->id,
            $pollresponse['poll_option_selection'] = $polloption_exists->id,
            ($request->text_response) && $pollresponse['text_response'] = $validated['text_response']
        ]);

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
