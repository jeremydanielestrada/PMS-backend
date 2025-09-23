<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Events\TaskUpdated;
use Illuminate\Support\Facades\Event;
use App\Listeners\CreateTaskNotification;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
       Event::listen(
            TaskUpdated::class,
            CreateTaskNotification::class
        );
    }
}
