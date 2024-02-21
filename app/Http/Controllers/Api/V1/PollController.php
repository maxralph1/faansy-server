<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Poll;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\PollResource;
use App\Http\Requests\StorePollRequest;
use App\Http\Requests\UpdatePollRequest;
use App\Models\Polloption;

class PollController extends Controller
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
        $polls = Poll::with([
            'polloptions',
            'polloptions.user',
            'pollresponses',
            'pollresponses.user',
            'user'
        ])->latest()->paginate();

        return PollResource::collection($polls);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePollRequest $request)
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated, $request) {
            $poll = new Poll();

            $poll['user_id'] = auth()->user()->id;
            $poll['questionnaire'] = $validated['questionnaire'];
            if ($request->close_time) $poll['close_time'] = $validated['close_time'];

            $poll->save();

            // Add the poll options
            $poll_option_1 = Polloption::create([
                'poll_id' => $poll->id,
                'user_id' => $poll->user_id,
                'option' => $validated['poll_option_1'],
            ]);

            $poll_option_2 = Polloption::create([
                'poll_id' => $poll->id,
                'user_id' => $poll->user_id,
                'option' => $validated['poll_option_2'],
            ]);

            if ($request->poll_option_3) {
                $poll_option_3 = Polloption::create([
                    'poll_id' => $poll->id,
                    'user_id' => $poll->user_id,
                    'option' => $validated['poll_option_3'],
                ]);
            }

            if ($request->poll_option_4) {
                $poll_option_4 = Polloption::create([
                    'poll_id' => $poll->id,
                    'user_id' => $poll->user_id,
                    'option' => $validated['poll_option_4'],
                ]);
            }

            return new PollResource($poll);
        });
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
