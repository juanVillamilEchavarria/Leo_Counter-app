<?php

namespace App\Providers\MovimientoFijo;

use App\Application\MovimientoFijo\Contracts\Queries\Executors\GetMovimientoFijoRecordsCountQueryExecutorContract;
use App\Application\MovimientoFijo\Contracts\Queries\Executors\MovimientoFijoQueryExecutorContract;
use App\Application\MovimientoFijo\Queries\Handlers\GetMovimientoFijoRecordsCountHandler;
use App\Application\MovimientoFijo\Queries\Handlers\ListAllMovimientoFijoHandler;
use App\Infrastructure\MovimientoFijo\Queries\Executors\Eloquent\EloquentGetMovimientoFijoRecordsCountExecutor;
use App\Infrastructure\MovimientoFijo\Queries\Executors\Eloquent\EloquentListAllMovimientoFijoWithDetailsExecutor;
use Illuminate\Support\ServiceProvider;

/**
 * Query executor provider del modulo MovimientoFijo.
 * Declara las implementaciones concretas que deben recibir los handlers de lectura.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Providers\MovimientoFijo
 * @since 1.0.0
 * @version 1.0.0
 */
final class MovimientoFijoQueryExecutorServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->when(ListAllMovimientoFijoHandler::class)
            ->needs(MovimientoFijoQueryExecutorContract::class)
            ->give(EloquentListAllMovimientoFijoWithDetailsExecutor::class);

        $this->app->when(GetMovimientoFijoRecordsCountHandler::class)
            ->needs(GetMovimientoFijoRecordsCountQueryExecutorContract::class)
            ->give(EloquentGetMovimientoFijoRecordsCountExecutor::class);
    }

    public function boot(): void
    {
        //
    }
}
