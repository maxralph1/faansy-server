<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Post;
use App\Models\Wallet;
use App\Models\Fanactivity;
use App\Models\Transaction;
use App\Models\Notification;
// use Illuminate\Http\Request;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Internaltransaction;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Block;

// use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['featuredPosts']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blocking = Block::where('blocked_id', auth()->user()->id)->first();

        $subscription = Subscription::where('subscriber_id', auth()->user()->id)->first();

        if ($blocking && $subscription) {
            $posts = Post::with([
                'user',
                'comments',
                'comments.user',
                'likes',
                'likes.user',
                'bookmarks',
                'bookmarks.user',
                'bookmarks.post',
                'bookmarks.post.comments',
                'bookmarks.post.likes',
            ])
                ->where('featured', true)
                ->where('user_id', '!=', $blocking?->blocker_id)
                ->where('user_id', '=', $subscription?->subscribed_id)
                ->latest()->paginate();

            return PostResource::collection($posts);
        }

        if ($blocking) {
            $posts = Post::with([
                'user',
                'comments',
                'comments.user',
                'likes',
                'likes.user',
                'bookmarks',
                'bookmarks.user',
                'bookmarks.post',
                'bookmarks.post.comments',
                'bookmarks.post.likes',
            ])
                ->where('featured', true)
                ->where('user_id', '!=', $blocking?->blocker_id)
                ->latest()->paginate();

            return PostResource::collection($posts);
        }

        if ($subscription) {
            $posts = Post::with([
                'user',
                'comments',
                'comments.user',
                'likes',
                'likes.user',
                'bookmarks',
                'bookmarks.user',
                'bookmarks.post',
                'bookmarks.post.comments',
                'bookmarks.post.likes',
            ])
                ->where('featured', true)
                ->where('user_id', '=', $subscription?->subscribed_id)
                ->latest()->paginate();

            return PostResource::collection($posts);
        }

        if (!$blocking && !$subscription) {
            $posts = Post::with([
                'user',
                'comments',
                'comments.user',
                'likes',
                'likes.user',
                'bookmarks',
                'bookmarks.user',
                'bookmarks.post',
                'bookmarks.post.comments',
                'bookmarks.post.likes',
            ])
                ->where('featured', true)
                ->latest()->paginate();

            return PostResource::collection($posts);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $validated = $request->validated();

        $post = new Post();

        if ($request->file('image_url')) {
            // Upload an Image File to Cloudinary with One line of Code
            // $uploadedFileUrl = Cloudinary::upload($validated['image_url'])->getRealPath())->getSecurePath();
            // // $uploadedFileUrl = Cloudinary::upload($request->file('image_url')->getRealPath())->getSecurePath();
            // $post['image_url'] = $uploadedFileUrl;

            $path = $validated['image_url']->store('images/posts');
            $post['image_url'] = $path;
        }

        if ($request->file('video_url')) {
            $path = $validated['video_url']->store('videos/posts');
            $post['video_url'] = $path;
        }

        $post['body'] = $validated['body'];

        $post->save();

        return new PostResource($post);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        function postPayPerView($post)
        {
            // Pay Per View Logic
            if ($post->pay_per_view == true) {
                // check viewer wallet balance, if they do not have enough balance, abort!
                $viewer_sufficient_fund = auth()->user()->wallet->balance >= $post->pay_per_view_amount;

                // if they have enough balance, charge the viewer
                if ($viewer_sufficient_fund) {
                    $viewer_wallet = Wallet::where('user_id', auth()->user()->id)->first();
                    $post_owner_wallet = Wallet::where('user_id', $post->user->id)->first();

                    DB::transaction(function () use ($viewer_wallet, $post_owner_wallet, $post) {
                        $viewer_wallet->update([
                            'balance' => $viewer_wallet->balance - $post->pay_per_view_amount
                        ]);

                        $post_owner_wallet->update([
                            'balance' => $post_owner_wallet->balance + (($post->pay_per_view_amount) * (96 / 100))
                        ]);

                        Transaction::create([
                            'beneficiary_id' => $post_owner_wallet->user->id,
                            'transactor_id' => $viewer_wallet->user->id, // || auth()->user()->id,
                            'transaction_type' => 'pay_per_view',
                            'amount' => $post->pay_per_view_amount,
                            'reference_id_to_resource' => $post->id,
                        ]);

                        $transaction = Transaction::create([
                            'beneficiary_id' => $post_owner_wallet->user->id, // || $post->user->id
                            'transactor_id' => $viewer_wallet->user->id, // || auth()->user()->id,
                            'transaction_type' => 'commission',
                            'amount' => - ($post->pay_per_view_amount * 100) * (4 / 100),
                            'reference_id_to_resource' => $post->id,
                        ]);

                        Notification::create([
                            'user_id' => $post->user->id,
                            'notification_type' => 'pay_per_view',
                            'monies_if_any' => $post->pay_per_view_amount * 100,
                            'reference_id_to_resource' => $post->id,
                            'transactor_id' => $viewer_wallet->user->id, // || auth()->user()->id,
                        ]);

                        Internaltransaction::create([
                            'transaction_type' => 'commission_on_pay_per_view',
                            'amount' => ($post->pay_per_view_amount * 100) * (4 / 100),
                            'reference_id_to_resource' => $post->id,
                            'reference_id_to_transaction' => $transaction->id,
                        ]);

                        // Add the viewer as a fan, if they're already not
                        $already_a_fan = Fanactivity::where([
                            'creator_id' => $post->user->id,
                            'fan_id' => $viewer_wallet->user->id
                        ])->first();

                        if (!$already_a_fan) {
                            Fanactivity::create([
                                'fan_id' => $viewer_wallet->user->id,
                                'creator_id' => $post->user->id,
                                'amount_paid_in_pay_per_view' => $post->pay_per_view_amount * 100,
                                'cumulative_amount_spent_on_creator_by_fan' => $post->pay_per_view_amount * 100
                            ]);
                        } elseif ($already_a_fan) {
                            $already_a_fan->update([
                                'amount_paid_in_pay_per_view' => $post->pay_per_view_amount * 100,
                                'cumulative_amount_spent_on_creator_by_fan' => $already_a_fan->cumulative_amount_spent_on_creator_by_fan + ($post->pay_per_view_amount * 100),
                            ]);
                        }

                        return new PostResource($post);
                    });
                } elseif (!$viewer_sufficient_fund) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Unauthorized. You must have sufficient funds in order to view this content.',
                    ], 403);
                }
            }
        }

        // Subscription Verification Logic
        if ($post->user->users_must_be_subscribed_to_view_my_content == true) {
            $subscription_exists = Subscription::where([
                'subscribed_id' => $post->user->id,
                'subscriber_id' => auth()->user()->id,
            ])->first();

            if ($subscription_exists) return new PostResource($post);

            postPayPerView($post);

            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized. You must be subscribed to creator in order to view this content.',
            ], 403);
        } elseif ($post->user->users_must_be_subscribed_to_view_my_content == false) {

            postPayPerView($post);

            return new PostResource($post);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        if ($request->user()->cannot('update', $post)) {
            abort(403);
        }

        $post->update($request->validated());

        return new PostResource($post);

        // $validated = $request->validated();

        // $post->update([
        //     'body' => $validated['body'],

        // ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Post $post)
    {
        if ($request->user()->cannot('delete', $post)) {
            abort(403);
        }

        $post->delete();
    }

    /**
     * Restore the specified deleted resource.
     */
    public function restore(Post $post)
    {
        $post->restore();
    }

    /**
     * Permanently remove the specified resource from storage.
     */
    public function forceDestroy(Post $post)
    {
        $post->forceDelete();
    }


    /**
     * Additional Methods
     */

    /**
     * Repost a post.
     */
    public function repost(StorePostRequest $request, Post $post)
    {
        if ($request->user()->cannot('repost', $post)) {
            abort(403);
        }

        $validated = $request->validated();

        $re_check_if_post_exists = Post::where('id', $validated['repost_original_id'])->first();

        if ($re_check_if_post_exists) {
            $validated['repost'] = true;

            $post = Post::create($validated);

            return new PostResource($post);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Post you are trying to repost does not exist or has been deleted.',
            ], 404);
        }
    }

    /**
     * Display a listing of featired posts.
     */
    public function featuredPosts()
    {
        $posts = Post::where('featured', true)->latest()->paginate();

        return PostResource::collection($posts);

        // $posts = Post::withTrashed()->latest()->paginate();

        // return PostResource::collection($posts);
    }

    /**
     * Make a post featured.
     */
    public function makePostFeatured(Post $post)
    {
        $post->update(['featured' => true]);

        return new PostResource($post);
    }

    /**
     * Display a listing of the authenticated user's posts.
     */
    public function myPosts()
    {
        $posts = Post::where('user_id', auth()->user()->id)->latest()->paginate();

        return PostResource::collection($posts);
    }

    /**
     * Pin a post.
     */
    public function pinPost(Post $post)
    {
        $post->update([
            'pinned' => true,
            'pinned_at' => now(),
        ]);

        return new PostResource($post);
    }

    /**
     * Find the specified resource.
     */
    public function searchPost($search_key)
    {
        //
    }
}
