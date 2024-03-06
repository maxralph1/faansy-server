<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Userbecomecreatorrequest;
use App\Http\Resources\UserbecomecreatorrequestResource;
use App\Http\Requests\UpdateUserbecomecreatorrequestRequest;

class UserbecomecreatorrequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userbecomecreatorrequests = Userbecomecreatorrequest::with('requester')->latest()->paginate();

        return UserbecomecreatorrequestResource::collection($userbecomecreatorrequests);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = User::find(auth()->user()->id);

        $already_verified = Userbecomecreatorrequest::where([
            'requesting_user_id' => auth()->user()->id,
            'approved' => true
        ])->first();

        if ($already_verified) {
            return response()->json([
                'status' => 'error',
                'message' => 'Conflict: Already Verified!',
            ], 409);
        }

        DB::transaction(function () use ($request, $user) {
            $validated = $request->validated();

            $path = $validated['verification_material_image_url']->store('images/users');

            $user->update([
                'verification_material_image_url' => $path,
            ]);

            $path = $validated['verification_material_image_url']->store('images/users/user-become-creator-requests');

            $userbecomeUserbecomecreatorrequest = Userbecomecreatorrequest::create([
                'verification_material_image_url' => $path,
                'requesting_user_id' => auth()->user()->id,
                'approving_user_id' => auth()->user()->id,
            ]);

            return new UserbecomecreatorrequestResource($userbecomeUserbecomecreatorrequest);
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(Userbecomecreatorrequest $userbecomecreatorrequest)
    {
        return new UserbecomecreatorrequestResource($userbecomecreatorrequest);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Userbecomecreatorrequest $userbecomecreatorrequest)
    {
        $userbecomecreatorrequest->delete();
    }

    /**
     * Restore the specified deleted resource.
     */
    public function restore(Userbecomecreatorrequest $userbecomecreatorrequest)
    {
        $userbecomecreatorrequest->restore();
    }

    /**
     * Permanently remove the specified resource from storage.
     */
    public function forceDestroy(Userbecomecreatorrequest $userbecomecreatorrequest)
    {
        $userbecomecreatorrequest->delete();
    }


    /**
     * Additional Methods
     */

    /**
     * Make request.
     */
    public function request(Userbecomecreatorrequest $userbecomecreatorrequest)
    {
        $userbecomecreatorrequest->update([
            'approved' => true,
            // 'rejected' => false,
            'approval_time' => now(),
            'requesting_user_id' => auth()->user()->id
        ]);

        return new UserbecomecreatorrequestResource($userbecomecreatorrequest);
    }

    /**
     * Approve request.
     */
    public function approve(Userbecomecreatorrequest $userbecomecreatorrequest)
    {
        DB::transaction(function () use ($userbecomecreatorrequest) {
            $userbecomecreatorrequest->update([
                'approved' => true,
                // 'rejected' => false,
                'approval_time' => now(),
                'approving_user_id' => auth()->user()->id
            ]);

            $user = User::where('id', $userbecomecreatorrequest->requesting_user_id)->first();

            $user->update([
                'verified' => true
            ]);

            return new UserbecomecreatorrequestResource($userbecomecreatorrequest);
        });
    }

    /**
     * Disapprove request.
     */
    public function reject(UpdateUserbecomecreatorrequestRequest $request, Userbecomecreatorrequest $userbecomecreatorrequest)
    {
        $validated = $request->validated();

        $userbecomecreatorrequest->update([
            // 'approved' => false,
            'rejected' => true,
            'reason_for_rejection' => $validated['reason_for_rejection'],
            'approval_time' => now(),
            'approving_user_id' => auth()->user()->id
        ]);

        return new UserbecomecreatorrequestResource($userbecomecreatorrequest);
    }
}
