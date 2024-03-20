<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Post;
use App\Models\Block;
use App\Models\Wallet;
use App\Models\Postimage;
use App\Models\Postvideo;
// use Illuminate\Http\Request;
use App\Models\Fanactivity;
use App\Models\Transaction;
use App\Models\Notification;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Internaltransaction;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Requests\StoreRepostRequest;
use App\Http\Resources\PostPublicResource;
use App\Http\Requests\StorePostrepostRequest;

// use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['featuredPosts', 'showPublic']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $blocking = Block::where('blocked_id', auth()->user()->id)->first();

        // $subscription = Subscription::where('subscriber_id', auth()->user()->id)->first();

        // if ($blocking && $subscription) {
        //     $posts = Post::with([
        //         'user',
        //         'comments',
        //         'comments.user',
        //         'likes',
        //         'likes.user',
        //         'bookmarks',
        //         'bookmarks.user',
        //         'bookmarks.post',
        //         'bookmarks.post.comments',
        //         'bookmarks.post.likes',
        //     ])
        //         ->where([
        //             'user_id' => auth()->user()->id,
        //             'featured' => true,
        //             'user_id', '!=', $blocking?->blocker_id,
        //             'user_id', '=', $subscription?->subscribed_id
        //         ])->latest()->paginate();

        //     return PostResource::collection($posts);
        // }

        // if ($blocking) {
        //     $posts = Post::with([
        //         'user',
        //         'comments',
        //         'comments.user',
        //         'likes',
        //         'likes.user',
        //         'bookmarks',
        //         'bookmarks.user',
        //         'bookmarks.post',
        //         'bookmarks.post.comments',
        //         'bookmarks.post.likes',
        //     ])
        //         ->where([
        //             'user_id' => auth()->user()->id,
        //             'featured' => true,
        //             'user_id', '!=', $blocking?->blocker_id
        //         ])->latest()->paginate();

        //     return PostResource::collection($posts);
        // }

        // if ($subscription) {
        //     $posts = Post::with([
        //         'user',
        //         'comments',
        //         'comments.user',
        //         'likes',
        //         'likes.user',
        //         'bookmarks',
        //         'bookmarks.user',
        //         'bookmarks.post',
        //         'bookmarks.post.comments',
        //         'bookmarks.post.likes',
        //     ])
        //         ->where([
        //             'user_id' => auth()->user()->id,
        //             'featured' => true,
        //             'user_id', '=', $subscription?->subscribed_id
        //         ])->latest()->paginate();

        //     return PostResource::collection($posts);
        // }

        // if (!$blocking && !$subscription) {
        //     $posts = Post::with([
        //         'user',
        //         'comments',
        //         'comments.user',
        //         'likes',
        //         'likes.user',
        //         'bookmarks',
        //         'bookmarks.user',
        //         'bookmarks.post',
        //         'bookmarks.post.comments',
        //         'bookmarks.post.likes',
        //     ])
        //         ->where([
        //             ['user_id' => auth()->user()->id] ||
        //                 ['featured' => true],
        //         ])->latest()->paginate();

        //     return PostResource::collection($posts);
        // }


        $blockings = Block::where('blocked_id', auth()->user()->id)->get();

        $subscriptions = Subscription::where('subscriber_id', auth()->user()->id)->get();

        if (auth()->user()->role->title == 'super-admin' || auth()->user()->role->title == 'admin') {
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
            ])->latest()->paginate();

            return PostResource::collection($posts);
        }

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
            ->orWhere('user_id', auth()->user()->id)
            ->latest()->paginate();

        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        if ($request->user()->cannot('create', Post::class)) {
            abort(403);
        };

        $validated = $request->validated();

        DB::transaction(function () use ($validated, $request) {
            $post = new Post();
            $post['body'] = $validated['body'];
            if ($request->scheduled_live_time) $post['scheduled_live_time'] = $validated['scheduled_live_time'];
            // $post['pay_per_view'] = $validated['pay_per_view'];
            if ($request->payperviewamount > 0) {
                $post['pay_per_view'] = true;
            } else {
                $post['pay_per_view'] = false;
            };
            if ($request->payperviewamount) $post['payperviewamount'] = $validated['payperviewamount'];

            $post->save();

            if ($request->file('image_url')) {
                // Upload an Image File to Cloudinary with One line of Code
                // $uploadedFileUrl = Cloudinary::upload($validated['image_url'])->getRealPath())->getSecurePath();
                // // $uploadedFileUrl = Cloudinary::upload($request->file('image_url')->getRealPath())->getSecurePath();
                // $post['image_url'] = $uploadedFileUrl;

                $image_path = $validated['image_url']->store('images/posts');

                Postimage::create([
                    'image_url' => $image_path,
                    'post_id' => $post->id,
                    'user_id' => auth()->user()->id,
                    'order' => '1',
                ]);
            }

            if ($request->file('image_url_2')) {
                $image_path_2 = $validated['image_url_2']->store('images/posts');

                Postimage::create([
                    'image_url' => $image_path_2,
                    'post_id' => $post->id,
                    'user_id' => auth()->user()->id,
                    'order' => '2',
                ]);
            }

            if ($request->file('image_url_3')) {
                $image_path_3 = $validated['image_url_3']->store('images/posts');

                Postimage::create([
                    'image_url' => $image_path_3,
                    'post_id' => $post->id,
                    'user_id' => auth()->user()->id,
                    'order' => '3'
                ]);
            }

            if ($request->file('image_url_4')) {
                $image_path_4 = $validated['image_url_4']->store('images/posts');

                Postimage::create([
                    'image_url' => $image_path_4,
                    'post_id' => $post->id,
                    'user_id' => auth()->user()->id,
                    'order' => '4'
                ]);
            }

            // if ($request->hasFile('video_url')) {
            if ($request->file('video_url')) {
                $video_path = $validated['video_url']->store('videos/posts');

                Postvideo::create([
                    'video_url' => $video_path,
                    'post_id' => $post->id,
                    'user_id' => auth()->user()->id
                ]);
            }

            return new PostResource($post);
        });
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
                $viewer_sufficient_fund = auth()->user()->wallet->balance >= $post->payperviewamount;

                // if they have enough balance, charge the viewer
                if ($viewer_sufficient_fund) {
                    $viewer_wallet = Wallet::where('user_id', auth()->user()->id)->first();
                    $post_owner_wallet = Wallet::where('user_id', $post->user->id)->first();

                    DB::transaction(function () use ($viewer_wallet, $post_owner_wallet, $post) {
                        $viewer_wallet->update([
                            'balance' => $viewer_wallet->balance - $post->payperviewamount
                        ]);

                        $post_owner_wallet->update([
                            'balance' => $post_owner_wallet->balance + (($post->payperviewamount) * (96 / 100))
                        ]);

                        Transaction::create([
                            'beneficiary_id' => $post_owner_wallet->user->id,
                            'transactor_id' => $viewer_wallet->user->id, // || auth()->user()->id,
                            'transaction_type' => 'pay_per_view_on_post',
                            'amount' => $post->payperviewamount,
                            'reference_id_to_resource' => $post->id,
                        ]);

                        $transaction = Transaction::create([
                            'beneficiary_id' => $post_owner_wallet->user->id, // || $post->user->id
                            'transactor_id' => $viewer_wallet->user->id, // || auth()->user()->id,
                            'transaction_type' => 'commission_on_pay_per_view_on_post',
                            'amount' => - ($post->payperviewamount * 100) * (4 / 100),
                            'reference_id_to_resource' => $post->id,
                        ]);

                        Notification::create([
                            'user_id' => $post->user->id,
                            'notification_type' => 'pay_per_view_on_post',
                            'monies_if_any' => $post->payperviewamount * 100,
                            'reference_id_to_resource' => $post->id,
                            'transactor_id' => $viewer_wallet->user->id, // || auth()->user()->id,
                        ]);

                        Internaltransaction::create([
                            'transaction_type' => 'commission_on_post_pay_per_view',
                            'amount' => ($post->payperviewamount * 100) * (4 / 100),
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
                                'amount_paid_in_pay_per_view' => $post->payperviewamount * 100,
                                'cumulative_amount_spent_on_creator_by_fan' => $post->payperviewamount * 100
                            ]);
                        } elseif ($already_a_fan) {
                            $already_a_fan->update([
                                'amount_paid_in_pay_per_view' => $already_a_fan->amount_paid_in_pay_per_view + ($post->payperviewamount * 100),
                                'cumulative_amount_spent_on_creator_by_fan' => $already_a_fan->cumulative_amount_spent_on_creator_by_fan + ($post->payperviewamount * 100),
                            ]);
                        }

                        // Payperview::create([
                        //     'user_id' => $viewer_wallet->user->id,
                        //     'post_id' => $message->id,
                        //     'content_type' => 'chat',
                        //     'payperview_amount_paid' => $message->payperviewamount * 100
                        // ]);

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

        // If viewed by post owner
        if ($post->user->id == auth()->user()->id) {
            return new PostResource($post);
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

        $validated = $request->validated();

        DB::transaction(function () use ($validated, $request, $post) {
            if ($request->body)  $post['body'] = $validated['body'];
            if ($request->scheduled_live_time) $post['scheduled_live_time'] = $validated['scheduled_live_time'];
            if ($request->payperviewamount > 0) {
                $post['pay_per_view'] = true;
            } else {
                $post['pay_per_view'] = false;
            };
            if ($request->payperviewamount) $post['payperviewamount'] = $validated['payperviewamount'];

            $post->update();

            if ($request->file('image_url')) {
                $image_1 = Postimage::where([
                    'post_id' => $post->id,
                    'order' => '1'
                ])->first();
                $image_path = $validated['image_url']->store('images/posts');
                $image_1['image_url'] = $image_path;
                $image_1->update();
            }

            if ($request->file('image_url_2')) {
                $image_2 = Postimage::where([
                    'post_id' => $post->id,
                    'order' => '2'
                ])->first();
                $image_path_2 = $validated['image_url_2']->store('images/posts');
                $image_2['image_url_2'] = $image_path_2;
                $image_2->update();
            }

            if ($request->file('image_url_3')) {
                $image_3 = Postimage::where([
                    'post_id' => $post->id,
                    'order' => '3'
                ])->first();
                $image_path_3 = $validated['image_url_3']->store('images/posts');
                $image_3['image_url'] = $image_path_3;
                $image_3->update();
            }

            if ($request->file('image_url_4')) {
                $image_4 = Postimage::where([
                    'post_id' => $post->id,
                    'order' => '4'
                ])->first();
                $image_path_4 = $validated['image_url_4']->store('images/posts');
                $image_4['image_url_4'] = $image_path_4;
                $image_4->update();
            }

            if ($request->file('video_url')) {
                $video = Postimage::where('post_id', $post->id)->first();
                $video_path = $validated['video_url']->store('videos/posts');
                $video['video_url'] = $video_path;
                $video->update();
            }

            return new PostResource($post);
        });
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
    public function repost(StoreRepostRequest $request, Post $post)
    {
        if ($request->user()->cannot('repost', $post)) {
            abort(403);
        }

        $validated = $request->validated();

        $repost = Post::create([
            'body' => $post->body,
            'pay_per_view' => $post->pay_per_view,
            'payperviewamount' => $post->payperviewamount,
            'repost' => true,
            'repost_original_id' => $post->id,
            // 'repost_body' => $validated['repost_body'],
            'repost_original_post_timestamp' => $post->created_at,
        ]);

        return new PostResource($repost);
    }

    /**
     * Display a listing of featired posts.
     */
    public function featuredPosts()
    {
        $posts = Post::where('featured', true)->latest()->paginate();

        return PostResource::collection($posts);
    }

    /**
     * Make a post featured.
     */
    public function makePostFeatured(Request $request, Post $post)
    // public function makePostFeatured(Post $post)
    {
        if ($request->user()->cannot('feature', $post)) {
            abort(403);
        }

        if ($post->featured == true) {
            return response()->json([
                'status' => 'error',
                'message' => 'Post is already featured.',
            ], 409);
        }

        // $post_object = Post::where('id', $post)
        //     ->update(['featured' => true]);

        $post_object = DB::table('posts')
            ->where('id', $post)
            ->update(['featured' => true]);

        // $post->update(['featured' => true]);

        return new PostResource($post_object);
        // return new PostResource($post);
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
    public function pinPost(Request $request, Post $post)
    {
        if ($request->user()->cannot('pin', $post)) {
            abort(403);
        }

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

    /**
     * Display the specified resource for unauthenticated viewers.
     */
    public function showPublic(Post $post)
    {
        return new PostPublicResource($post);
    }
}
