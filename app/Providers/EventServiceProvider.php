<?php

namespace App\Providers;

use App\Models\Tip;
use App\Models\Chat;
use App\Models\Post;
use App\Models\Block;
use App\Models\Bookmark;
use App\Observers\TipObserver;
use App\Observers\ChatObserver;
use App\Observers\PostObserver;
use App\Observers\BlockObserver;
use App\Observers\BookmarkObserver;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
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
        Tip::class => [TipObserver::class],
        Chat::class => [ChatObserver::class],
        Post::class => [PostObserver::class],
        Block::class => [BlockObserver::class],
        Bookmark::class => [BookmarkObserver::class],
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
