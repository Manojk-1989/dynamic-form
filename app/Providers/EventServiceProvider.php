<?php

namespace App\Providers;

// use Illuminate\Support\ServiceProvider;
use App\Events\FormCreated;
use App\Listeners\SendFormCreatedNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        FormCreated::class => [
            SendFormCreatedNotification::class,
        ],
    ];
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
