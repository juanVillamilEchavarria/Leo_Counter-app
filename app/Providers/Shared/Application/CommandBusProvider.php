<?php

namespace App\Providers\Shared\Application;

use Illuminate\Support\ServiceProvider;
use App\Shared\Application\Contracts\Bus\CommandBus;
use App\Shared\Infrastructure\Framework\Laravel\Buses\LaravelCommandBus;

class CommandBusProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(CommandBus::class, LaravelCommandBus::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
