<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->role->title === 'super-admin' || $user->role->title === 'admin';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Post $post): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role->title === 'super-admin' || $user->role->title === 'admin' || $user->role->title === 'creator';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Post $post): bool
    {
        return $user->role->title === 'super-admin' || $user->role->title === 'admin';
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Post $post): bool
    {
        return $user->role->title === 'super-admin' || $user->role->title === 'admin';
    }

    /**
     * Additional Methods
     */

    /**
     * Determine whether the user can repost a post.
     */
    public function repost(User $user, Post $post): bool
    // public function repost(User $user, Post $post): Response
    {
        return $user->id === $post->user_id;
        // return $user->id === $post->user_id
        //     ? Response::allow()
        //     : Response::deny('You cannot repost a post that does not belong to you.');
    }

    /**
     * Determine whether the user can make a post featured.
     */
    public function feature(User $user, Post $post): bool
    {
        return $user->role->title === 'super-admin' || $user->role->title === 'admin';
    }

    /**
     * Determine whether the user can pin a post.
     */
    public function pin(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }
}
