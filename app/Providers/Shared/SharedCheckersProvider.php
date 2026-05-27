<?php

namespace App\Providers\Shared;

use Illuminate\Support\ServiceProvider;
use App\Shared\Domain\Contracts\Checkers\UsuarioCanBeNotifiedByAChannelCheckerContract;
use App\Shared\Infrastructure\Queries\Executors\Checkers\EloquentUsuarioCanBeNotifiedByChannelChecker;

class SharedCheckersProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UsuarioCanBeNotifiedByAChannelCheckerContract::class, EloquentUsuarioCanBeNotifiedByChannelChecker::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
