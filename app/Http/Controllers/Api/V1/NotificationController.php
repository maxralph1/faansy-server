<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;

class NotificationController extends Controller
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
        // $notifications = Notification::latest()->paginate();
        $notifications = Notification::where('user_id', auth()->user()->id)->latest()->paginate();

        return NotificationResource::collection($notifications);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Notification $notification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notification $notification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notification $notification)
    {
        //
    }

    /**
     * Mark notification as read featured.
     */
    public function markAsRead(Notification $notification)
    {
        $notification->update(['read' => true]);

        return new NotificationResource($notification);
    }
}
