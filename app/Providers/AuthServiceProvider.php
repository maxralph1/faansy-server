<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Tip;
use App\Models\Card;
use App\Models\Poll;
use App\Models\Post;
use App\Models\Block;
use App\Models\Story;
use App\Models\Wallet;
use App\Models\Message;
use App\Models\Profile;
use App\Models\Bookmark;
use App\Models\Postlike;
use App\Models\Restrict;
use App\Models\Userlike;
use App\Models\Polloption;
use App\Models\Postcomment;
use App\Policies\TipPolicy;
use App\Models\Pollresponse;
use App\Models\Subscription;
use App\Policies\CardPolicy;
use App\Policies\PollPolicy;
use App\Policies\PostPolicy;
use App\Models\Walletfunding;
use App\Policies\BlockPolicy;
use App\Policies\StoryPolicy;
use App\Policies\WalletPolicy;
use App\Policies\MessagePolicy;
use App\Policies\ProfilePolicy;
use App\Policies\BookmarkPolicy;
use App\Policies\PostlikePolicy;
use App\Policies\RestrictPolicy;
use App\Policies\UserlikePolicy;
use App\Policies\PolloptionPolicy;
use App\Policies\PostcommentPolicy;
use App\Policies\PollresponsePolicy;
use App\Policies\SubscriptionPolicy;
use App\Policies\WalletfundingPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Profile::class => ProfilePolicy::class,
        Post::class => PostPolicy::class,
        Block::class => BlockPolicy::class,
        Bookmark::class => BookmarkPolicy::class,
        Card::class => CardPolicy::class,
        Message::class => MessagePolicy::class,
        Polloption::class => PolloptionPolicy::class,
        Poll::class => PollPolicy::class,
        Pollresponse::class => PollresponsePolicy::class,
        Postcomment::class => PostcommentPolicy::class,
        Postlike::class => PostlikePolicy::class,
        Restrict::class => RestrictPolicy::class,
        Story::class => StoryPolicy::class,
        Subscription::class => SubscriptionPolicy::class,
        Tip::class => TipPolicy::class,
        Userlike::class => UserlikePolicy::class,
        Walletfunding::class => WalletfundingPolicy::class,
        Wallet::class => WalletPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
