<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */

namespace App\Providers\Propietario\Application;

use App\Application\Propietario\Contracts\Queries\Executors\GetPropietarioRecordsCountQueryExecutorContract;
use App\Application\Propietario\Contracts\Queries\Executors\PropietarioQueryExecutorContract;
use App\Application\Propietario\Queries\Handlers\GetPropietariosRecordsCountHandler;
use App\Application\Propietario\Queries\Handlers\ListAllPropietariosWithDetailsHandler;
use App\Infrastructure\Propietario\Queries\Executors\Eloquent\EloquentGetPropietariosRecordsCountQueryExecutor;
use App\Infrastructure\Propietario\Queries\Executors\Eloquent\EloquentListAllPropietariosWithDetailsQueryExecutor;
use App\Infrastructure\Propietario\Queries\Strategies\EloquentPropietarioExportQueryStrategy;
use Illuminate\Support\ServiceProvider;

class PropietarioQueryExecutorsProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->tag([
            EloquentPropietarioExportQueryStrategy::class,
        ], 'export.query.strategies');

        $this->app->when(ListAllPropietariosWithDetailsHandler::class)
            ->needs(PropietarioQueryExecutorContract::class)
            ->give(EloquentListAllPropietariosWithDetailsQueryExecutor::class);

        $this->app->when(GetPropietariosRecordsCountHandler::class)
            ->needs(GetPropietarioRecordsCountQueryExecutorContract::class)
            ->give(EloquentGetPropietariosRecordsCountQueryExecutor::class);

    }

    public function boot(): void {}
}
