<?php

namespace App\Providers\Cuenta\Application;

use App\Application\Cuenta\Queries\Handlers\ListAllCuentasWithDetailsHandler;
use App\Application\Cuenta\Queries\Handlers\ListCuentasRecordsCountHandler;
use App\Infrastructure\Cuenta\Queries\Executors\Eloquent\EloquentListAllCuentasWithDetailsExecutor;
use App\Infrastructure\Cuenta\Queries\Executors\Eloquent\EloquentListCuentasRecordsCountExecutor;
use App\Application\Cuenta\Contracts\Queries\Executors\CuentaQueryExecutorContract;
use Illuminate\Support\ServiceProvider;

class CuentaQueryExecutorsProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->when(ListAllCuentasWithDetailsHandler::class)
            ->needs(CuentaQueryExecutorContract::class)
            ->give(EloquentListAllCuentasWithDetailsExecutor::class);

        $this->app->when(ListCuentasRecordsCountHandler::class)
            ->needs(CuentaQueryExecutorContract::class)
            ->give(EloquentListCuentasRecordsCountExecutor::class);
    }

    public function boot(): void
    {
        //
    }
}