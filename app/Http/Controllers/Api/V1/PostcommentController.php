<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Postcomment;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostcommentResource;
use App\Http\Requests\StorePostcommentRequest;
use App\Http\Requests\UpdatePostcommentRequest;

class PostcommentController extends Controller
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
        $postcomments = Postcomment::withTrashed()->latest()->paginate();

        return PostcommentResource::collection($postcomments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostcommentRequest $request)
    {
        $postcomment = Postcomment::create($request->validated());

        return new PostcommentResource($postcomment);
    }

    /**
     * Display the specified resource.
     */
    public function show(Postcomment $postcomment)
    {
        return new PostcommentResource($postcomment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostcommentRequest $request, Postcomment $postcomment)
    {
        $postcomment->update($request->validated());

        return new PostcommentResource($postcomment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Postcomment $postcomment)
    {
        $postcomment->delete();
    }

    /**
     * Restore the specified deleted resource.
     */
    public function restore(Postcomment $postcomment)
    {
        $postcomment->restore();
    }

    /**
     * Permanently remove the specified resource from storage.
     */
    public function forceDestroy(Postcomment $postcomment)
    {
        $postcomment->forceDelete();
    }
}
