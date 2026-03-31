<?php

namespace App\Domains\Profile\Repositories\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domains\Profile\Repositories\Application\Eloquent\EloquentProfileRepository;
use App\Domains\Profile\Repositories\Contracts\ProfileRepositoryContract;

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
