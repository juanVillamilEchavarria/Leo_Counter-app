<?php

namespace App\Providers\Propietario\Infrastructure;

use Illuminate\Support\ServiceProvider;
use App\Application\Propietario\Contracts\Queries\Executors\PropietarioShowQueryExecutorContract;
use App\Infrastructure\Propietario\Queries\Executors\Eloquent\EloquentPropietarioShowQueryExecutor;
class PropietarioShowQueryExecutorProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(PropietarioShowQueryExecutorContract::class, EloquentPropietarioShowQueryExecutor::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
