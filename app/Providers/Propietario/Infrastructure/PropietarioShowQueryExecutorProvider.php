<?php

namespace App\Providers\Propietario\Infrastructure;

use Illuminate\Support\ServiceProvider;
use App\Application\Propietario\Contracts\Queries\Executors\PropietarioForShowQueryExecutorContract;
use App\Infrastructure\Propietario\Queries\Executors\Eloquent\EloquentPropietarioForShowQueryExecutor;
class PropietarioShowQueryExecutorProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(PropietarioForShowQueryExecutorContract::class, EloquentPropietarioForShowQueryExecutor::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
