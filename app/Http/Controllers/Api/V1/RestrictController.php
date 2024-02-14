<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Restrict;
use App\Http\Controllers\Controller;
use App\Http\Resources\RestrictResource;
use App\Http\Requests\StoreRestrictRequest;
use App\Http\Requests\UpdateRestrictRequest;

class RestrictController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $restricts = Restrict::where('restrictor_id', auth()->id)->latest()->paginate();

        return RestrictResource::collection($restricts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRestrictRequest $request)
    {
        $already_restricted = Restrict::where([
            'restrictor_id' => $request->restrictor_id,
            'restrictee_id' => $request->restrictee_id,
        ])->first();

        if ($already_restricted) {
            return response()->json([
                'status' => 'error',
                'message' => 'Conflict: Already Restricted!',
            ], 409);
            // abort('409', 'Conflict: Already Restricted!');
        }

        $restrict = Restrict::create($request->validated());

        return new RestrictResource($restrict);
    }

    /**
     * Display the specified resource.
     */
    public function show(Restrict $restrict)
    {
        return new RestrictResource($restrict);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRestrictRequest $request, Restrict $restrict)
    {
        $restrict->update($request->validated());

        return new RestrictResource($restrict);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Restrict $restrict)
    {
        $restrict->delete();
    }

    /**
     * Restore the specified deleted resource.
     */
    public function restore(Restrict $restrict)
    {
        $restrict->restore();
    }

    /**
     * Permanently remove the specified resource from storage.
     */
    public function forceDestroy(Restrict $restrict)
    {
        $restrict->forceDelete();
    }
}
