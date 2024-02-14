<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Subscription;
use App\Http\Controllers\Controller;
use App\Http\Resources\SubscriptionResource;
use App\Http\Requests\StoreSubscriptionRequest;
use App\Http\Requests\UpdateSubscriptionRequest;

class SubscriptionController extends Controller
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
        $subscriptions = Subscription::where('subscriber_id', auth()->user()->id)
            ->orWhere('subscribed_id', auth()->user()->id)
            ->latest()
            ->paginate();

        return SubscriptionResource::collection($subscriptions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubscriptionRequest $request)
    {
        $already_subscribed = Subscription::where([
            'subscriber_id' => $request->subscriber_id,
            'subscribed_id' => $request->subscribed_id,
        ])->first();

        if ($already_subscribed) {
            return response()->json([
                'status' => 'error',
                'message' => 'Conflict: Already Subscribed!',
            ], 409);
        }

        $subscription = new Subscription();

        $validated = $request->validated();

        if ($request->subscriber_id == auth()->user()->id) {

            if ($request->subscription_amount_paid == null) {
                $subscription['subscription_amount_paid'] = 0;
            }

            $subscription['subscribed_id'] = $validated['subscribed_id'];
            $subscription['subscriber_id'] = $validated['subscriber_id'];
        }

        $subscription->save();

        // $subscription = Subscription::create($request->validated());

        return new SubscriptionResource($subscription);
    }

    /**
     * Display the specified resource.
     */
    public function show(Subscription $subscription)
    {
        return new SubscriptionResource($subscription);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubscriptionRequest $request, Subscription $subscription)
    {
        $subscription->update($request->validated());

        return new SubscriptionResource($subscription);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subscription $subscription)
    {
        $subscription->delete();
    }

    /**
     * Restore the specified deleted resource.
     */
    public function restore(Subscription $subscription)
    {
        $subscription->restore();
    }

    /**
     * Permanently remove the specified resource from storage.
     */
    public function forceDestroy(Subscription $subscription)
    {
        $subscription->forceDelete();
    }
}
