<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Chat;
use App\Http\Controllers\Controller;
use App\Http\Resources\ChatResource;
use App\Http\Requests\StoreChatRequest;
use App\Http\Requests\UpdateChatRequest;

class ChatController extends Controller
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
        $chats = Chat::with([
            'participator_1',
            'participator_2',
            'messages',
            'messages.user'
        ])
            ->where('participator_1_id', auth()->user()->id)
            ->orWhere('participator_2_id', auth()->user()->id)
            ->latest()
            ->paginate();

        return ChatResource::collection($chats);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreChatRequest $request)
    {
        // $chat_exists = Chat::where([
        //     'participator_1_id', $request->participator_1_id,
        //     'participator_2_id', $request->participator_2_id,
        // ])
        //     ->orWhere([
        //         'participator_1_id', $request->participator_2_id,
        //         'participator_2_id', $request->participator_1_id,
        //     ])->first();

        $chat_exists = Chat::where('slug', $request->participator_1_id . '_' . $request->participator_2_id)
            ->orWhere('participator_2_id', $request->participator_2_id . '_' . $request->participator_1_id)->first();

        // $chat_exists && abort(409);
        if ($chat_exists) {
            abort(409);
        };

        $chat = Chat::create($request->validated());

        return new ChatResource($chat);
    }

    /**
     * Display the specified resource.
     */
    public function show(Chat $chat)
    {
        return new ChatResource($chat);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateChatRequest $request, Chat $chat)
    {
        // $chat->update($request->validated());

        // return new ChatResource($chat);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chat $chat)
    {
        $chat->delete();
    }

    /**
     * Restore the specified deleted resource.
     */
    public function restore(Chat $chat)
    {
        $chat->restore();
    }

    /**
     * Permanently remove the specified resource from storage.
     */
    public function forceDestroy(Chat $chat)
    {
        $chat->forceDelete();
    }
}
