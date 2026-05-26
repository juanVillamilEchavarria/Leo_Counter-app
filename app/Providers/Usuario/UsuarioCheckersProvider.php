<?php

namespace App\Providers\Usuario;

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
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
