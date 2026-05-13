<?php

namespace App\Providers\Shared\Application;

use Illuminate\Support\ServiceProvider;
use App\Shared\Application\Contracts\Queries\Executors\GetTipoMovimientoNameQueryExecutorContract;
use App\Shared\Infrastructure\Queries\Executors\EloquentGetTipoMovimientoNameQueryExecutor;


class QueryExecutorsProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(GetTipoMovimientoNameQueryExecutorContract::class, EloquentGetTipoMovimientoNameQueryExecutor::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
