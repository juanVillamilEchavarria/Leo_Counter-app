<?php

namespace App\Providers\Shared;

use Illuminate\Support\ServiceProvider;
use App\Shared\Application\Contracts\Services\AuthServiceContract;
use App\Shared\Infrastructure\Framework\Laravel\Services\Auth\LaravelAuthService;
class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
       $this->app->singleton(AuthServiceContract::class, LaravelAuthService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
