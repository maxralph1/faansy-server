<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Chat;
use App\Models\Wallet;
use App\Models\Message;
use App\Models\Fanactivity;
use App\Models\Transaction;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;
use App\Models\Internaltransaction;
use App\Http\Controllers\Controller;
use App\Http\Resources\MessageResource;
use App\Http\Requests\StoreMessageRequest;
use App\Http\Requests\UpdateMessageRequest;
use App\Http\Requests\StoreNewMessageRequest;

class MessageController extends Controller
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
        // $messages = Message::latest()->paginate();

        // return MessageResource::collection($messages);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMessageRequest $request)
    {
        $validated = $request->validated();

        $message = new Message();
        $message['chat_id'] = $validated['chat_id'];
        $message['user_id'] = auth()->user()->id;
        if ($request->body) {
            $message['body'] = $validated['body'];
        }
        if ($request->pay_per_view) {
            $message['pay_per_view'] = $validated['pay_per_view'];
        };
        if ($request->pay_per_view != 0) {
            if ($request->payperviewamount) {
                $message['payperviewamount'] = $validated['payperviewamount'];
            };
        };
        if ($request->file('image_url')) {
            $image_path = $validated['image_url']->store('images/chats');

            $message['image_url'] = $image_path;
        }

        if ($request->file('video_url')) {
            $video_path = $validated['video_url']->store('videos/chats');

            $message['video_url'] = $video_path;
        }

        $message->save();

        return new MessageResource($message);
    }

    /**
     * Display the specified resource.
     */
    public function show(Message $message)
    {
        function messagePayPerView($message)
        {
            if ($message->pay_per_view == true) {
                // check viewer wallet balance, if they do not have enough balance, abort!
                $viewer_sufficient_fund = auth()->user()->wallet->balance >= $message->pay_per_view_amount;

                // if they have enough balance, charge the viewer
                if ($viewer_sufficient_fund) {
                    $viewer_wallet = Wallet::where('user_id', auth()->user()->id)->first();
                    $message_owner_wallet = Wallet::where('user_id', $message->user->id)->first();

                    DB::transaction(function () use ($viewer_wallet, $message_owner_wallet, $message) {
                        $viewer_wallet->update([
                            'balance' => $viewer_wallet->balance - $message->payperviewamount
                        ]);

                        $message_owner_wallet->update([
                            'balance' => $message_owner_wallet->balance + (($message->payperviewamount) * (96 / 100))
                        ]);

                        Transaction::create([
                            'beneficiary_id' => $message_owner_wallet->user->id,
                            'transactor_id' => $viewer_wallet->user->id,
                            'transaction_type' => 'pay_per_view_in_chat',
                            'amount' => $message->payperviewamount,
                            'reference_id_to_resource' => $message->id
                        ]);

                        $transaction = Transaction::create([
                            'beneficiary_id' => $message_owner_wallet->user->id,
                            'transactor_id' => $viewer_wallet->user->id,
                            'transaction_type' => 'commission_on_pay_per_view_in_chat',
                            'amount' => - ($message->payperviewamount * 100) * (4 / 100),
                            'reference_id_to_resource' => $message->id,
                        ]);

                        Notification::create([
                            'user_id' => $message->user->id,
                            'notification_type' => 'pay_per_view_in_chat',
                            'monies_if_any' => $message->payperviewamount * 100,
                            'reference_id_to_resource' => $message->id,
                            'transactor_id' => $viewer_wallet->user->id,
                        ]);

                        Internaltransaction::create([
                            'transaction_type' => 'commission_on_pay_per_view',
                            'amount' => ($message->payperviewamount * 100) * (4 / 100),
                            'reference_id_to_resource' => $message->id,
                            'reference_id_to_transaction' => $transaction->id,
                        ]);

                        // Add the viewer as a fan, if they're already not
                        $already_a_fan = Fanactivity::where([
                            'creator_id' => $message->user->id,
                            'fan_id' => $viewer_wallet->user->id
                        ])->first();

                        if (!$already_a_fan) {
                            Fanactivity::create([
                                'fan_id' => $viewer_wallet->user->id,
                                'creator_id' => $message->user->id,
                                'amount_paid_in_pay_per_view' => $message->payperviewamount * 100,
                                'cumulative_amount_spent_on_creator_by_fan' => $message->payperviewamount * 100
                            ]);
                        } elseif ($already_a_fan) {
                            $already_a_fan->update([
                                'amount_paid_in_pay_per_view' => $message->payperviewamount * 100,
                                'cumulative_amount_spent_on_creator_by_fan' => $already_a_fan->cumulative_amount_spent_on_creator_by_fan + ($message->payperviewamount * 100),
                            ]);
                        }

                        return new MessageResource($message);
                    });
                } elseif (!$viewer_sufficient_fund) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Unauthorized. You must have sufficient funds in order to view this content.',
                    ], 403);
                }
            }
        }

        // If viewed by post owner
        if ($message->user->id == auth()->user()->id) {
            return new MessageResource($message);
        }

        // else
        messagePayPerView($message);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMessageRequest $request, Message $message)
    {
        $message->update($request->validated());

        return new MessageResource($message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        $message->delete();
    }

    /**
     * Restore the specified deleted resource.
     */
    public function restore(Message $message)
    {
        $message->restore();
    }

    /**
     * Permanently remove the specified resource from storage.
     */
    public function forceDestroy(Message $message)
    {
        $message->forceDelete();
    }

    /**
     * Store a new message and create chat model if none exists.
     */
    public function storeNewMessage(StoreNewMessageRequest $request)
    {
        $message = new Message();

        $validated = $request->validated();

        if (($validated['participator_1_id'] == $validated['participator_2_id']) || (($validated['participator_1_id'] == auth()->user()->id) && ($validated['participator_2_id'] == auth()->user()->id))) abort(409);

        $chat_already_exists = Chat::where([
            'participator_1_id' => $request->participator_1_id,
            'participator_2_id' => $request->participator_2_id,
        ])
            ->orWhere([
                'participator_1_id' => $request->participator_2_id,
                'participator_2_id' => $request->participator_2_id,
            ])
            ->first();

        if ($chat_already_exists) {
            $message['body'] = $validated['body'];
            $message['chat_id'] = $chat_already_exists->id;
            $message['user_id'] = $validated['participator_1_id'];
        } elseif (!$chat_already_exists) {
            $new_chat = Chat::create([
                'participator_1_id' => $validated['participator_1_id'],
                'participator_2_id' => $validated['participator_2_id'],
            ]);

            $message['body'] = $validated['body'];
            $message['chat_id'] = $new_chat->id;
            $message['user_id'] = $validated['participator_1_id'];
        }

        $message->save();

        return new MessageResource($message);
    }
}
