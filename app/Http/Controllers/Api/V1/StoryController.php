<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Story;
use App\Http\Controllers\Controller;
use App\Http\Resources\StoryResource;
use App\Http\Requests\StoreStoryRequest;
use App\Http\Requests\UpdateStoryRequest;

class StoryController extends Controller
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
        $stories = Story::latest()->paginate();

        return StoryResource::collection($stories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStoryRequest $request)
    {
        $story = Story::create($request->validated());

        return new StoryResource($story);
    }

    /**
     * Display the specified resource.
     */
    public function show(Story $story)
    {
        return new StoryResource($story);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStoryRequest $request, Story $story)
    {
        $story->update($request->validated());

        return new StoryResource($story);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Story $story)
    {
        $story->delete();
    }

    /**
     * Restore the specified deleted resource.
     */
    public function restore(Story $story)
    {
        $story->restore();
    }

    /**
     * Permanently remove the specified resource from storage.
     */
    public function forceDestroy(Story $story)
    {
        $story->forceDelete();
    }
}
