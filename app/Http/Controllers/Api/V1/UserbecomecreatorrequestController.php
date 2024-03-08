<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Userbecomecreatorrequest;
use App\Http\Resources\UserbecomecreatorrequestResource;
use App\Http\Requests\StoreUserbecomecreatorrequestRequest;
use App\Http\Requests\UpdateUserbecomecreatorrequestRequest;
use App\Models\Role;

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
    public function store(StoreUserbecomecreatorrequestRequest $request)
    {
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

        DB::transaction(function () use ($request) {
            $validated = $request->validated();

            $path = $validated['verification_material_image_url']->store('images/users/user-become-creator-requests');

            $userbecomeUserbecomecreatorrequest = Userbecomecreatorrequest::create([
                'verification_material_image_url' => $path,
                'requesting_user_id' => auth()->user()->id,
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
     * Approve request.
     */
    public function approve(Userbecomecreatorrequest $userbecomecreatorrequest)
    {
        DB::transaction(function () use ($userbecomecreatorrequest) {
            $userbecomecreatorrequest->update([
                'approved' => true,
                'approval_time' => now(),
                'rejected' => false,
                'rejection_time' => null,
                'reason_for_rejection' => null,
                'approving_user_id' => auth()->user()->id
            ]);

            $user = User::where('id', $userbecomecreatorrequest->requesting_user_id)->first();
            $role = Role::where('title', 'creator')->first();

            $user->update([
                'role_id' => $role->id,
                // 'verification_material_image_url' => $userbecomecreatorrequest->verification_material_image_url,
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

        DB::transaction(function () use ($validated, $request, $userbecomecreatorrequest) {

            $userbecomecreatorrequest = Userbecomecreatorrequest::find($validated['id']);
            $role = Role::where('title', 'generic-user')->first();

            if ($request->reason_for_rejection) {
                $userbecomecreatorrequest->update([
                    'approved' => false,
                    'approval_time' => null,
                    'rejected' => true,
                    'rejection_time' => now(),
                    'reason_for_rejection' => $validated['reason_for_rejection'],
                    'approving_user_id' => auth()->user()->id
                ]);
            }

            $userbecomecreatorrequest->update([
                'approved' => false,
                'approval_time' => null,
                'rejected' => true,
                'rejection_time' => now(),
                'reason_for_rejection' => null,
                'approving_user_id' => auth()->user()->id
            ]);

            $user = User::where('id', $userbecomecreatorrequest->requesting_user_id)->first();

            $user->update([
                'role_id' => $role->id,
                // 'verification_material_image_url' => null,
            ]);

            return new UserbecomecreatorrequestResource($userbecomecreatorrequest);
        });
    }
}
