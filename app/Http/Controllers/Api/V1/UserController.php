<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
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

        // return new UserCollection($user);
        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        // return new UserCollection($user);
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());

        // return new UserCollection($user);
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
     * Update the specified resource in storage.
     */
    public function verifyCreator(UpdateUserRequest $request, User $user)
    {
        // $user = User::firstWhere('username', $user->username);

        $user->update(['verified' => true]);

        return new UserResource($user);
    }
}
