<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Fanactivity;
use App\Http\Controllers\Controller;
use App\Http\Resources\FanactivityResource;

class FanactivityController extends Controller
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
        $fanactivities = Fanactivity::with([
            'creator',
            'fan'
        ])
            ->where('creator_id', auth()->user()->id)
            ->latest()
            ->paginate();

        return FanactivityResource::collection($fanactivities);
    }

    /**
     * Display the specified resource.
     */
    public function show(Fanactivity $fanactivity)
    {
        return new FanactivityResource($fanactivity);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fanactivity $fanactivity)
    {
        $fanactivity->delete();
    }

    /**
     * Restore the specified deleted resource.
     */
    public function restore(Fanactivity $fanactivity)
    {
        $fanactivity->restore();
    }

    /**
     * Permanently remove the specified resource from storage.
     */
    public function forceDestroy(Fanactivity $fanactivity)
    {
        $fanactivity->forceDelete();
    }
}
