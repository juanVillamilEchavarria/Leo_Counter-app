<?php

namespace App\Providers\Cuenta\Application;

use App\Application\Cuenta\Queries\Handlers\ListAllCuentasWithDetailsHandler;
use App\Application\Cuenta\Queries\Handlers\ListCuentasRecordsCountHandler;
use App\Infrastructure\Cuenta\Queries\Executors\Eloquent\EloquentListAllCuentasWithDetailsQueryExecutor;
use App\Infrastructure\Cuenta\Queries\Executors\Eloquent\EloquentGetCuentasRecordsCountQueryExecutor;
use App\Application\Cuenta\Contracts\Queries\Executors\CuentaQueryExecutorContract;
use App\Application\Cuenta\Contracts\Queries\Executors\GetCuentaRecordsCountQueryExecutorContract;
use Illuminate\Support\ServiceProvider;

class CuentaQueryExecutorsProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->when(ListAllCuentasWithDetailsHandler::class)
            ->needs(CuentaQueryExecutorContract::class)
            ->give(EloquentListAllCuentasWithDetailsQueryExecutor::class);

        $this->app->when(ListCuentasRecordsCountHandler::class)
            ->needs(GetCuentaRecordsCountQueryExecutorContract::class)
            ->give(EloquentGetCuentasRecordsCountQueryExecutor::class);
    }

    public function boot(): void
    {
        //
    }
}
