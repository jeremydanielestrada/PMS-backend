<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\TaskUpdated;
use App\Listeners\CreateTaskNotification;

class EventServiceProvider extends ServiceProvider
{
   protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        TaskUpdated::class => [
            CreateTaskNotification::class,
        ],
    ];

    public function boot(): void
    {
        //
    }

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
