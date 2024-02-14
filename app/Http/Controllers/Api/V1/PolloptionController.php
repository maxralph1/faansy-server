<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Polloption;
use App\Http\Controllers\Controller;
use App\Http\Resources\PolloptionResource;
use App\Http\Requests\StorePolloptionRequest;
use App\Http\Requests\UpdatePolloptionRequest;

class PolloptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $polloptions = Polloption::latest()->paginate();

        return PolloptionResource::collection($polloptions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePolloptionRequest $request)
    {
        $polloption = Polloption::create($request->validated());

        return new PolloptionResource($polloption);
    }

    /**
     * Display the specified resource.
     */
    public function show(Polloption $polloption)
    {
        return new PolloptionResource($polloption);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePolloptionRequest $request, Polloption $polloption)
    {
        $polloption->update($request->validated());

        return new PolloptionResource($polloption);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Polloption $polloption)
    {
        $polloption->delete();
    }

    /**
     * Restore the specified deleted resource.
     */
    public function restore(Polloption $polloption)
    {
        $polloption->restore();
    }

    /**
     * Permanently remove the specified resource from storage.
     */
    public function forceDestroy(Polloption $polloption)
    {
        $polloption->forceDelete();
    }
}
