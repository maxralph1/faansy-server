<?php

namespace App\Providers;

use App\Models\Tip;
use App\Models\Card;
use App\Models\Chat;
use App\Models\Post;
use App\Models\Block;
use App\Models\Message;
use App\Models\Bookmark;
use App\Models\Postlike;
use App\Models\Postcomment;
use App\Observers\TipObserver;
use App\Observers\CardObserver;
use App\Observers\ChatObserver;
use App\Observers\PostObserver;
use App\Models\Userverification;
use App\Observers\BlockObserver;
use App\Observers\MessageObserver;
use App\Observers\BookmarkObserver;
use App\Observers\PostlikeObserver;
use Illuminate\Support\Facades\Event;
use App\Observers\PostcommentObserver;
use Illuminate\Auth\Events\Registered;
use App\Observers\UserverificationObserver;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * The model observers.
     *
     * @var array
     */
    protected $observers = [
        Bookmark::class => [BookmarkObserver::class],
        Block::class => [BlockObserver::class],
        Card::class => [CardObserver::class],
        Chat::class => [ChatObserver::class],
        Message::class => [MessageObserver::class],
        Post::class => [PostObserver::class],
        Postcomment::class => [PostcommentObserver::class],
        Postlike::class => [PostlikeObserver::class],
        Tip::class => [TipObserver::class],
        Userverification::class => [UserverificationObserver::class]
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
