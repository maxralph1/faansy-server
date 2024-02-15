<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Chat;
use App\Models\Message;
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
        $message = Message::create($request->validated());

        return new MessageResource($message);
    }

    /**
     * Display the specified resource.
     */
    public function show(Message $message)
    {
        return new MessageResource($message);
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
