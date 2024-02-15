<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Postlike;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostlikeResource;
use App\Http\Requests\StorePostlikeRequest;
use App\Http\Requests\UpdatePostlikeRequest;

class PostlikeController extends Controller
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
        $postlikes = Postlike::with([
            'post',
            'post.user',
            'user',
        ])->latest()->paginate();

        return PostlikeResource::collection($postlikes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostlikeRequest $request)
    {
        $already_liked = Postlike::where([
            'post_id' => $request->post_id,
            'user_id' => $request->user_id,
        ])->first();

        if ($already_liked) {
            return response()->json([
                'status' => 'error',
                'message' => 'Conflict: Already Liked!',
            ], 409);
        }

        $postlike = Postlike::create($request->validated());

        return new PostlikeResource($postlike);
    }

    /**
     * Display the specified resource.
     */
    public function show(Postlike $postlike)
    {
        return new PostlikeResource($postlike);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostlikeRequest $request, Postlike $postlike)
    {
        $postlike->update($request->validated());

        return new PostlikeResource($postlike);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Postlike $postlike)
    {
        $postlike->delete();
    }

    /**
     * Restore the specified deleted resource.
     */
    public function restore(Postlike $postlike)
    {
        $postlike->restore();
    }

    /**
     * Permanently remove the specified resource from storage.
     */
    public function forceDestroy(Postlike $postlike)
    {
        $postlike->forceDelete();
    }
}
