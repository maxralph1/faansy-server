<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Tip;
use App\Models\Wallet;
use App\Models\Fanactivity;
use App\Models\Transaction;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\TipResource;
use App\Models\Internaltransaction;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTipRequest;
use App\Http\Requests\UpdateTipRequest;

class TipController extends Controller
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
        $tips = Tip::with([
            'recipient',
            'donor'
        ])->where('recipient_id', auth()->user()->id)
            ->orWhere('donor_id', auth()->user()->id)
            ->latest()
            ->paginate();

        return TipResource::collection($tips);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTipRequest $request)
    {
        // check donor wallet balance, if they do not have enough balance, abort!
        $donor_sufficient_fund = auth()->user()->wallet->balance >= $request->amount;

        // if they have enough wallet balance, charge the donor
        if ($donor_sufficient_fund && $request->amount > 0) {
            $donor_wallet = Wallet::where('user_id', $request->donor_id)->first();
            $recipient_wallet = Wallet::where('user_id', $request->recipient_id)->first();

            DB::transaction(function () use ($donor_wallet, $recipient_wallet, $request) {
                // DB::beginTransaction();

                $tip = Tip::create($request->validated());

                $donor_wallet->update([
                    'balance' => $donor_wallet->balance - $tip->amount
                ]);

                // $total_amount_credited_to_recipient = (96 / ($tip->amount)) * 100;
                $recipient_wallet->update([
                    'balance' => $recipient_wallet->balance + (($tip->amount) * (96 / 100))
                ]);

                Transaction::create([
                    'beneficiary_id' => $tip->recipient_id,
                    'transactor_id' => $tip->donor_id,
                    'transaction_type' => 'tip',
                    'amount' => $tip->amount * 100,
                    'reference_id_to_resource' => $tip->id,
                ]);

                $transaction = Transaction::create([
                    'beneficiary_id' => $tip->recipient_id,
                    'transactor_id' => $tip->donor_id,
                    'transaction_type' => 'commission',
                    'amount' => - ($tip->amount * 100) * (4 / 100),
                    'reference_id_to_resource' => $tip->id,
                ]);

                Notification::create([
                    'user_id' => $recipient_wallet->user->id,
                    'notification_type' => 'tip',
                    'monies_if_any' => $tip->amount * 100,
                    'reference_id_to_resource' => $tip->id,
                    'transactor_id' => $tip->donor_id,
                ]);

                Internaltransaction::create([
                    'transaction_type' => 'commission_on_tip',
                    'amount' => ($tip->amount * 100) * (4 / 100),
                    'reference_id_to_resource' => $tip->id,
                    'reference_id_to_transaction' => $transaction->id,
                ]);

                // Add the donor as a fan, if they're already not
                $already_a_fan = Fanactivity::where([
                    'creator_id' => $tip->recipient_id,
                    'fan_id' => $tip->donor_id
                ])->first();

                if (!$already_a_fan) {
                    Fanactivity::create([
                        'fan_id' => $tip->donor_id,
                        'creator_id' => $tip->recipient_id,
                        'amount_paid_in_tip' => $tip->amount * 100,
                        'cumulative_amount_spent_on_creator_by_fan' => $tip->amount * 100
                    ]);
                } elseif ($already_a_fan) {
                    $already_a_fan->update([
                        'amount_paid_in_tip' => $tip->amount * 100,
                        'cumulative_amount_spent_on_creator_by_fan' => $already_a_fan->cumulative_amount_spent_on_creator_by_fan + ($tip->amount * 100),
                    ]);
                }

                return new TipResource($tip);

                // DB::commit();
            });
        } elseif (!$donor_sufficient_fund) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized. You must have sufficient funds in order to view this content.',
            ], 403);
        }

        // $tip = Tip::create($request->validated());

        // return new TipResource($tip);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tip $tip)
    {
        return new TipResource($tip);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTipRequest $request, Tip $tip)
    {
        $tip->update($request->validated());

        return new TipResource($tip);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tip $tip)
    {
        $tip->delete();
    }

    /**
     * Restore the specified deleted resource.
     */
    public function restore(Tip $tip)
    {
        $tip->restore();
    }

    /**
     * Permanently remove the specified resource from storage.
     */
    public function forceDestroy(Tip $tip)
    {
        $tip->forceDelete();
    }
}
