<?php

namespace App\Providers\Propietario\Application;

use Illuminate\Support\ServiceProvider;
use App\Application\Propietario\Queries\Handlers\ListAllPropietariosWithDetailsHandler;
use App\Application\Propietario\Queries\Handlers\GetPropietariosRecordsCountHandler;
use App\Application\Propietario\Contracts\Queries\Executors\PropietarioQueryExecutorContract;
use App\Application\Propietario\Contracts\Queries\Executors\GetPropietarioRecordsCountQueryExecutorContract;
use App\Infrastructure\Propietario\Queries\Executors\Eloquent\EloquentListAllPropietariosWithDetailsQueryExecutor;
use App\Infrastructure\Propietario\Queries\Executors\Eloquent\EloquentGetPropietariosRecordsCountQueryExecutor;

class PropietarioQueryExecutorsProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->when(ListAllPropietariosWithDetailsHandler::class)
            ->needs(PropietarioQueryExecutorContract::class)
            ->give(EloquentListAllPropietariosWithDetailsQueryExecutor::class);

        $this->app->when(GetPropietariosRecordsCountHandler::class)
            ->needs(GetPropietarioRecordsCountQueryExecutorContract::class)
            ->give(EloquentGetPropietariosRecordsCountQueryExecutor::class);
        

    }

    public function boot(): void
    {
    }
}
