<?php

namespace App\Providers\Shared\Application\Services;

use Illuminate\Support\ServiceProvider;
use App\Shared\Application\Contracts\Services\FileServiceContract;
use App\Shared\Infrastructure\Framework\Laravel\Services\Files\LaravelFileService;

class FileServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(FileServiceContract::class, LaravelFileService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
