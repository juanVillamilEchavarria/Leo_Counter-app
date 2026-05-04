<?php

namespace App\Providers\Shared\Application;

use Illuminate\Support\ServiceProvider;
use App\Shared\Infrastructure\Framework\Laravel\Buses\LaravelQueryBus;
use App\Shared\Application\Contracts\Bus\QueryBus;

class QueryBusPovider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(QueryBus::class, LaravelQueryBus::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
