<?php

namespace App\Application\Profile\Providers\Repositories;

use Illuminate\Support\ServiceProvider;
use App\Infrastructure\Persistence\Repositories\Eloquent\Profile\EloquentProfileRepository;
use App\Domains\Profile\Contracts\Repositories\ProfileRepositoryContract;

class ProfileRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(ProfileRepositoryContract::class, EloquentProfileRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
