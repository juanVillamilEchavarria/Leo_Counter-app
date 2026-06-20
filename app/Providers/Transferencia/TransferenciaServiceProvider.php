<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
namespace App\Providers\Transferencia;

use Illuminate\Support\ServiceProvider;
use App\Domains\Transferencia\Contracts\Repositories\TransferenciaRepositoryContract;
use App\Infrastructure\Transferencia\Persistence\Repositories\Eloquent\EloquentTransferenciaRepository;
use App\Application\Transferencia\Contracts\Queries\Executors\TransferenciaQueryExecutorContract;
use App\Infrastructure\Transferencia\Queries\Executors\Eloquent\EloquentListTransferenciasExecutor;
use App\Application\Transferencia\Queries\Handlers\ListTransferenciasForTableHandler;
use App\Application\Transferencia\Contracts\Queries\Executors\TransferenciaPaginatedTableQueryExecutorContract;
use App\Infrastructure\Transferencia\Queries\Executors\Eloquent\EloquentTransferenciaPaginatedTableQueryExecutor;

class TransferenciaServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(TransferenciaRepositoryContract::class, EloquentTransferenciaRepository::class);
        $this->app->singleton(TransferenciaQueryExecutorContract::class, EloquentListTransferenciasExecutor::class);

        // Binding para listado paginado (tabla) de transferencias siguiendo el patrón de Movimientos
        $this->app->when(ListTransferenciasForTableHandler::class)
            ->needs(TransferenciaPaginatedTableQueryExecutorContract::class)
            ->give(EloquentTransferenciaPaginatedTableQueryExecutor::class);

        $this->app->singleton(TransferenciaPaginatedTableQueryExecutorContract::class, EloquentTransferenciaPaginatedTableQueryExecutor::class);

        // Binding para obtener el conteo total de transferencias
        $this->app->bind(
            \App\Application\Transferencia\Contracts\Queries\Executors\GetTransferenciaRecordsCountQueryExecutorContract::class,
            \App\Infrastructure\Transferencia\Queries\Executors\Eloquent\EloquentGetTransferenciaRecordsCountQueryExecutor::class
        );
    }

    public function boot(): void
    {
        //
    }
}
