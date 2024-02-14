<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Post;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Notification;
use App\Models\Subscription;
use App\Models\Transaction;

// use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'show', 'featuredPosts']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $posts = Post::withTrashed()->latest()->paginate();
        $posts = Post::latest()->paginate();

        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $post = new Post();

        $validated = $request->validated();

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

        $post['user_id'] = $validated['user_id'];
        $post['body'] = $validated['body'];

        $post->save();

        return new PostResource($post);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        // Pay Per View Logic
        if ($post->pay_per_view == true) {
            // check subscriber wallet balance, if they do not have enough balance, abort!
            $subscriber_sufficient_fund = auth()->user()->wallet->balance >= $post->pay_per_view_amount;

            // if they have enough balance, charge the subscriber
            if ($subscriber_sufficient_fund) {
                $subscriber_wallet = Wallet::where('user_id', auth()->id)->first();
                $subscribed_wallet = Wallet::where('user_id', $post->user->id)->first();

                DB::transaction(function () use ($subscriber_wallet, $subscribed_wallet, $post) {
                    // $subscriber_wallet_balance = $subscriber_wallet->balance;
                    // $subscribed_wallet_balance = $subscribed_wallet->balance;

                    $subscriber_wallet->update([
                        'balance' => $subscriber_wallet->balance - $post->pay_per_view_amount
                    ]);

                    $subscribed_wallet->update([
                        'balance' => $subscribed_wallet->balance + ((96 / $post->pay_per_view_amount) * 100)
                    ]);

                    Transaction::create([
                        'beneficiary_id' => $subscribed_wallet->user->id,
                        'transactor_id' => auth()->id,
                        'transaction_type' => 'pay_per_view',
                        'amount' => $post->pay_per_view_amount,
                        'reference_id_to_resource' => $post->id,
                    ]);

                    Transaction::create([
                        'beneficiary_id' => $subscribed_wallet->user->id,
                        'transactor_id' => auth()->id,
                        'transaction_type' => 'commission',
                        'amount' => (4 / $post->pay_per_view_amount) * 100,
                        'reference_id_to_resource' => $post->id,
                    ]);

                    Notification::create([
                        'user_id' => $post->user->id,
                        'notification_type' => 'pay_per_view',
                        'monies_if_any' => $post->pay_per_view_amount,
                        'reference_id_to_resource' => $post->id,
                        'transactor_id' => auth()->id,
                    ]);
                });

                return new PostResource($post);
            } elseif (!$subscriber_sufficient_fund) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized. You must have sufficient funds in order to view this content.',
                ], 403);
            }
        }

        // Subscription Logic
        if ($post->user->users_must_be_subscribed_to_view_my_content == true) {
            $subscription_exists = Subscription::where([
                'subscribed_id' => $post->user->id,
                'subscriber_id' => auth()->id,
            ])->first();

            return new PostResource($post);
        } elseif ($post->user->users_must_be_subscribed_to_view_my_content == false) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized. You must be subscribed to creator in order to view this content.',
            ], 403);
        }

        return new PostResource($post);
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
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
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
    public function repost(StorePostRequest $request)
    {
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
