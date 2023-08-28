<?php

namespace App\Providers;

use App\Events\MessageProcess;
use App\Events\NewUser;
use App\Events\UserProcess;
use App\Listeners\createNewUser;
use App\Listeners\MessageHandler;
use App\Listeners\UsersHandler;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;


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
        NewUser::class => [
            createNewUser::class
        ],
        UserProcess::class => [
            UsersHandler::class
        ],
        MessageProcess::class => [
            MessageHandler::class
        ],

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
