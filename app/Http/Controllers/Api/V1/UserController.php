<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Role;
use App\Models\User;
use App\Models\Userverification;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserCollection;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\StoreVerifyProfileRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\VerifyprofileRequest;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['showPublic']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::latest()
            ->paginate();

        // return UserCollection::collection($users);
        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $request->validated();

        $user = User::create([
            'username' => $request->username,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => Role::where('title', 'generic-user')->first()->id,
        ]);

        event(new Registered($user));

        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        if ($request->user()->cannot('update', $user)) {
            abort(403);
        }

        $validated = $request->validated();

        $user['first_name'] = $validated['first_name'];
        $user['last_name'] = $validated['last_name'];
        $user['username'] = $validated['username'];
        $user['email'] = $validated['email'];

        if ($request->file('user_image_url')) {
            $user_image_path = $validated['user_image_url']->store('images/users/user-images');
            $user['user_image_url'] = $user_image_path;
        }

        if ($request->file('user_background_image_url')) {
            $user_background_image_path = $validated['user_background_image_url']->store('images/users/user-background-images');
            $user['user_background_image_url'] = $user_background_image_path;
        }

        $user['show_activity_status'] = $validated['show_activity_status'];
        $user['free_subscription'] = $validated['free_subscription'];
        $user['subscription_amount'] = $validated['subscription_amount'];
        $user['show_subscription_offers'] = $validated['show_subscription_offers'];
        // $user['dark_mode'] = $validated['dark_mode'];

        $user->update();

        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateProfilePhoto(UpdateUserRequest $request, User $user)
    {
        if ($request->user()->cannot('update', $user)) {
            abort(403);
        }

        $validated = $request->validated();

        $user_image_path = $validated['user_image_url']->store('images/users/user-images');
        $user['user_image_url'] = $user_image_path;

        $user->update();

        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateBackgroundPhoto(UpdateUserRequest $request, User $user)
    {
        if ($request->user()->cannot('update', $user)) {
            abort(403);
        }

        $validated = $request->validated();

        $user_background_image_path = $validated['user_background_image_url']->store('images/users/user-background-images');
        $user['user_background_image_url'] = $user_background_image_path;

        $user->update();

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->noContent();
    }

    /**
     * Display a listing of the resource.
     */
    public function creators()
    {
        $creator_role = Role::where('title', 'creator')->first();

        $creators = User::with([
            'role',
            'profile',
            'posts',
            'posts.comments',
            'postcomments',
            'posts.likes',
            'postlikes',
            // 'livestreams',
            // 'livestreamcomments',
            // 'livestreamlikes',
            'userlikers',
            'subscribed',

        ])->where('role_id', $creator_role->id)->inRandomOrder()
            ->take(5)->get();

        // return UserCollection::collection($creators);
        return UserResource::collection($creators);
    }

    /**
     * Display the specified resource.
     */
    public function creator(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     */
    public function myProfile()
    {
        $my_profile = User::where('id', auth()->user()->id)->first();

        return new UserResource($my_profile);
    }

    /**
     * Update the specified resource in storage.
     */
    public function verifyCreator(UpdateUserRequest $request, User $user)
    {
        // $user = User::firstWhere('username', $user->username);

        $user->update(['verified' => true]);

        return new UserResource($user);
    }

    /**
     * Display the specified resource for unauthenticated viewers.
     */
    public function showPublic(User $user)
    {
        return new UserResource($user);
    }
}
