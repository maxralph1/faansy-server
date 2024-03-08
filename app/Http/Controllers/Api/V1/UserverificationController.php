<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Models\Userverification;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserverificationResource;
use App\Http\Requests\StoreUserverificationRequest;
use App\Http\Requests\UpdateUserverificationRequest;

class UserverificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userverifications = Userverification::with('requester')->latest()->paginate();

        return UserverificationResource::collection($userverifications);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserverificationRequest $request)
    {
        $already_verified = Userverification::where([
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

            $path = $validated['verification_material_image_url']->store('images/users/verifications');

            $userverification = Userverification::create([
                'verification_material_image_url' => $path,
                'requesting_user_id' => auth()->user()->id,
            ]);

            return new UserverificationResource($userverification);
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(Userverification $userverification)
    {
        return new UserverificationResource($userverification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Userverification $userverification)
    {
        $userverification->delete();
    }

    /**
     * Restore the specified deleted resource.
     */
    public function restore(Userverification $userverification)
    {
        $userverification->restore();
    }

    /**
     * Permanently remove the specified resource from storage.
     */
    public function forceDestroy(Userverification $userverification)
    {
        $userverification->forceDelete();
    }


    /**
     * Additional Methods
     */

    /**
     * Approve verification.
     */
    public function approve(Userverification $userverification)
    {
        DB::transaction(function () use ($userverification) {
            $userverification->update([
                'approved' => true,
                'approval_time' => now(),
                'rejected' => false,
                'rejection_time' => null,
                'reason_for_rejection' => null,
                'approving_user_id' => auth()->user()->id
            ]);

            $user = User::where('id', $userverification->requesting_user_id)->first();

            $user->update([
                'verification_material_image_url' => $userverification->verification_material_image_url,
                'verified' => true
            ]);

            return new UserverificationResource($userverification);
        });
    }

    /**
     * Disapprove verification.
     */
    public function reject(UpdateUserverificationRequest $request)
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated, $request) {

            $userverification = Userverification::find($validated['id']);

            if ($request->reason_for_rejection) {
                $userverification->update([
                    'approved' => false,
                    'approval_time' => null,
                    'rejected' => true,
                    'rejection_time' => now(),
                    'reason_for_rejection' => $validated['reason_for_rejection'],
                    'approving_user_id' => auth()->user()->id
                ]);
            }

            $userverification->update([
                'approved' => false,
                'approval_time' => null,
                'rejected' => true,
                'rejection_time' => now(),
                'reason_for_rejection' => null,
                'approving_user_id' => auth()->user()->id
            ]);

            $user = User::where('id', $userverification->requesting_user_id)->first();

            $user->update([
                'verification_material_image_url' => null,
                'verified' => false
            ]);

            return new UserverificationResource($userverification);
        });
    }
}
