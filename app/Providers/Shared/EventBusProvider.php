<?php

namespace App\Providers\Shared;

use Illuminate\Support\ServiceProvider;
use App\Shared\Application\Contracts\Bus\EventBus;
use App\Shared\Infrastructure\Framework\Laravel\Buses\LaravelEventBus;
class EventBusProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(EventBus::class, LaravelEventBus::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
