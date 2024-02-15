<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Card;
use App\Models\Wallet;
use App\Models\Transaction;
use App\Models\Notification;
use App\Models\Walletfunding;
use Illuminate\Support\Facades\DB;
use App\Models\Internaltransaction;
use App\Http\Controllers\Controller;
use App\Http\Resources\WalletfundingResource;
use App\Http\Requests\StoreWalletfundingRequest;
use App\Http\Requests\UpdateWalletfundingRequest;

class WalletfundingController extends Controller
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
        $walletfundings = Walletfunding::with([
            'user',
            'card',
            'wallet'
        ])->latest()
            ->paginate();

        return WalletfundingResource::collection($walletfundings);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWalletfundingRequest $request)
    {
        $validated = $request->validated();

        // Users can only fund their wallet
        $user_wallet = Wallet::find(auth()->user()->id);

        // Proceed to charge the credit card
        $credit_card = Card::find($validated['card_id']);

        // If charge successful, fund the wallet with the amount, else abort


        // Fund the wallet amount charged on the credit card (i.e. the user input (request) amount)
        DB::transaction(function () use ($validated, $user_wallet, $credit_card) {
            $walletfunding = new Walletfunding();

            $walletfunding['user_id'] = auth()->user()->id;
            $walletfunding['card_id'] = $credit_card->id;
            $walletfunding['wallet_id'] = $user_wallet->id;
            $walletfunding['amount_funded'] = $validated['amount_funded'];

            $walletfunding->save();

            $user_wallet->update([
                'balance' => $walletfunding->amount_funded,
            ]);

            Transaction::create([
                'beneficiary_id' => $user_wallet->user->id,
                'transactor_id' => auth()->user()->id,
                'transaction_type' => 'wallet_funding',
                'amount' => $walletfunding->amount_funded,
                'reference_id_to_resource' => $walletfunding->id,
            ]);

            $transaction = Transaction::create([
                'beneficiary_id' => $user_wallet->user->id,
                'transactor_id' => auth()->user()->id,
                'transaction_type' => 'commission_on_wallet_funding',
                'amount' => - ($walletfunding->amount_funded * 100) * (4 / 100),
                'reference_id_to_resource' => $walletfunding->id,
            ]);

            Notification::create([
                'user_id' => $user_wallet->user->id,
                'notification_type' => 'wallet_funding',
                'monies_if_any' => $walletfunding->amount_funded * 100,
                'reference_id_to_resource' => $walletfunding->id,
                'transactor_id' => auth()->user()->id,
            ]);

            Internaltransaction::create([
                'transaction_type' => 'commission_on_wallet_funding',
                'amount' => ($walletfunding->amount_funded * 100) * (4 / 100),
                'reference_id_to_resource' => $walletfunding->id,
                'reference_id_to_transaction' => $transaction->id,
            ]);

            return new WalletfundingResource($walletfunding);
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(Walletfunding $walletfunding)
    {
        return new WalletfundingResource($walletfunding);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWalletfundingRequest $request, Walletfunding $walletfunding)
    {
        $walletfunding->update($request->validated());

        return new WalletfundingResource($walletfunding);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Walletfunding $walletfunding)
    {
        $walletfunding->delete();
    }

    /**
     * Restore the specified deleted resource.
     */
    public function restore(Walletfunding $walletfunding)
    {
        $walletfunding->restore();
    }

    /**
     * Permanently remove the specified resource from storage.
     */
    public function forceDestroy(Walletfunding $walletfunding)
    {
        $walletfunding->forceDelete();
    }


    /**
     * Additional Methods
     */

    /**
     * Display a listing of the resource.
     */
    public function myWalletfunding()
    {
        $walletfunding = Walletfunding::where('user_id', auth()->id)
            ->latest()
            ->paginate();

        return WalletfundingResource::collection($walletfunding);
    }
}
