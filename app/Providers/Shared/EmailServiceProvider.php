<?php

namespace App\Providers\Shared;

use App\Shared\Application\Contracts\Services\EmailServiceContract;
use App\Shared\Infrastructure\Framework\Laravel\Services\Notifications\LaravelEmailService;
use Illuminate\Support\ServiceProvider;

class EmailServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(EmailServiceContract::class, LaravelEmailService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
