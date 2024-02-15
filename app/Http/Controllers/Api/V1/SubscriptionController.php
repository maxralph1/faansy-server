<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Models\Wallet;
use App\Models\Transaction;
use App\Models\Notification;
use App\Models\Subscription;
use Illuminate\Support\Facades\DB;
use App\Models\Internaltransaction;
use App\Http\Controllers\Controller;
use App\Http\Resources\SubscriptionResource;
use App\Http\Requests\StoreSubscriptionRequest;
use App\Http\Requests\UpdateSubscriptionRequest;
use App\Models\Fanactivity;

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
        $subscriptions = Subscription::with([
            'subscribed',
            'subscriber'
        ])->where('subscriber_id', auth()->user()->id)
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
        $validated = $request->validated();

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

        // Initialize subscription object to make it accessible everywhere
        $subscription = new Subscription();

        // Find Creator 
        $creator = User::find($request->subscribed_id);

        // Check if subscription is free
        if ($creator->subscription_amount != 0 || $creator->subscription_amount != null) {

            $subscription['subscribed_id'] = $validated['subscribed_id'];
            $subscription['subscriber_id'] = $validated['subscriber_id'];

            $subscription->save();

            return new SubscriptionResource($subscription);
        }

        // If subscription is not free, proceed

        // check subscriber wallet balance, if they do not have enough balance, abort!
        $subscriber_sufficient_fund = auth()->user()->wallet->balance >= $creator->subscription_amount;

        // if they have enough wallet balance, charge the subscriber
        if (
            $subscriber_sufficient_fund
            && ($creator->subscription_amount != 0 || $creator->subscription_amount != null)
        ) {
            $subscriber_wallet = Wallet::where('user_id', $request->donor_id)->first();
            $creator_wallet = Wallet::where('user_id', $creator->id)->first();

            DB::transaction(function () use ($request, $validated, $subscription, $subscriber_wallet, $creator_wallet, $creator) {
                // DB::beginTransaction();

                if ($request->subscriber_id == auth()->user()->id) {

                    if ($request->subscription_amount_paid == null) {
                        $subscription['subscription_amount_paid'] = 0;
                    }

                    $subscription['subscribed_id'] = $validated['subscribed_id'];
                    $subscription['subscriber_id'] = $validated['subscriber_id'];
                }

                $subscriber_wallet->update([
                    'balance' => $subscriber_wallet->balance - $creator->subscription_amount
                ]);

                // $total_amount_credited_to_recipient = (96 / ($tip->amount)) * 100;
                $creator_wallet->update([
                    'balance' => $creator_wallet->balance + (($creator->subscription_amount) * (96 / 100))
                ]);

                Transaction::create([
                    'beneficiary_id' => $creator->id,
                    'transactor_id' => auth()->user()->id,
                    'transaction_type' => 'subscription',
                    'amount' => $creator->subscription_amount * 100,
                    'reference_id_to_resource' => $subscription->id,
                ]);

                $transaction = Transaction::create([
                    'beneficiary_id' => $creator->id,
                    'transactor_id' => auth()->user()->id,
                    'transaction_type' => 'commission',
                    'amount' => - ($creator->subscription_amount * 100) * (4 / 100),
                    'reference_id_to_resource' => $subscription->id,
                ]);

                Notification::create([
                    'user_id' => $creator->id,
                    'notification_type' => 'subscription',
                    'monies_if_any' => $creator->subscription_amount * 100,
                    'reference_id_to_resource' => $subscription->id,
                    'transactor_id' => auth()->user()->id,
                ]);

                Internaltransaction::create([
                    'transaction_type' => 'commission_on_subscription',
                    'amount' => ($creator->subscription_amount * 100) * (4 / 100),
                    'reference_id_to_resource' => $subscription->id,
                    'reference_id_to_transaction' => $transaction->id,
                ]);

                // Add the subscriber as a fan, if they're already not
                $already_a_fan = Fanactivity::where([
                    'creator_id' => $creator->id,
                    'fan_id' => $subscriber_wallet->user->id
                ])->first();

                if (!$already_a_fan) {
                    Fanactivity::create([
                        'fan_id' => $subscriber_wallet->user->id,
                        'creator_id' => $creator->id,
                        'amount_paid_in_subscription' => $creator->subscription_amount * 100,
                        'cumulative_amount_spent_on_creator_by_fan' => $creator->subscription_amount * 100
                    ]);
                } elseif ($already_a_fan) {
                    $already_a_fan->update([
                        'amount_paid_in_subscription' => $creator->subscription_amount * 100,
                        'cumulative_amount_spent_on_creator_by_fan' => $already_a_fan->cumulative_amount_spent_on_creator_by_fan + ($creator->subscription_amount * 100),
                    ]);
                }

                return new SubscriptionResource($subscription);

                // DB::commit();
            });
        } elseif (!$subscriber_sufficient_fund) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized. You must have sufficient funds in order to subscribe to this creator.',
            ], 403);
        }
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
