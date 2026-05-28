<?php

namespace App\Providers\Usuario;

use App\Domains\Usuario\Contracts\Checkers\UsuarioUniquinessCheckerContract;
use App\Infrastructure\Usuario\Queries\Executors\Eloquent\Checkers\EloquentUsuarioUniquinessChecker;
use Illuminate\Support\ServiceProvider;
use App\Domains\Usuario\Contracts\Checkers\UsuarioCanUpdatePublicDataCheckerContract;
use App\Infrastructure\Usuario\Queries\Executors\Eloquent\Checkers\EloquentUsuarioCanUpdatePublicDataChecker;
class UsuarioCheckersProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UsuarioCanUpdatePublicDataCheckerContract::class, EloquentUsuarioCanUpdatePublicDataChecker::class);
        $this->app->singleton(UsuarioUniquinessCheckerContract::class, EloquentUsuarioUniquinessChecker::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
