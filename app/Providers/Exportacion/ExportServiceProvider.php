<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */

namespace App\Providers\Exportacion;

use App\Application\Exportacion\Commands\CleanExportacionesCommand;
use App\Application\Exportacion\Commands\DestroyExportacionCommand;
use App\Application\Exportacion\Commands\ExportDataCommand;
use App\Application\Exportacion\Commands\Handlers\CleanExportacionesHandler;
use App\Application\Exportacion\Commands\Handlers\DestroyExportacionHandler;
use App\Application\Exportacion\Commands\Handlers\ExportDataHandler as ExportDataCommandHandler;
use App\Application\Exportacion\Commands\Handlers\StoreExportacionHandler;
use App\Application\Exportacion\Commands\StoreExportacionCommand;
use App\Application\Exportacion\Contracts\Queries\Executors\ExportacionPaginatedTableQueryExecutorContract;
use App\Application\Exportacion\Contracts\Queries\Executors\GetExportacionesRecordsCountQueryExecutorContract;
use App\Application\Exportacion\Contracts\Queries\Executors\ListOldExportacionesQueryExecutorContract;
use App\Application\Exportacion\Contracts\Repositories\ExportacionRepositoryContract;
use App\Application\Exportacion\Contracts\Services\ExportFileServiceContract;
use App\Application\Exportacion\Queries\Handlers\GetExportacionesRecordsCountHandler;
use App\Application\Exportacion\Queries\Handlers\ListExportacionesForTableHandler;
use App\Application\Exportacion\Queries\Handlers\ListOldExportacionesHandler;
use App\Application\Exportacion\Queries\Resolvers\ExportQueryResolver;
use App\Infrastructure\Exportacion\Persistence\EloquentExportacionRepository;
use App\Infrastructure\Exportacion\Queries\Executors\Eloquent\EloquentExportacionPaginatedTableQueryExecutor;
use App\Infrastructure\Exportacion\Queries\Executors\Eloquent\EloquentGetExportacionesRecordsCountQueryExecutor;
use App\Infrastructure\Exportacion\Queries\Executors\Eloquent\EloquentListOldExportacionesQueryExecutor;
use App\Infrastructure\Exportacion\Services\OpenSpoutExportFileService;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\ServiceProvider;

/**
 * Service provider del módulo Exportación.
 * Registra el servicio de archivos, el repositorio de logging, el mapeo de
 * comandos a handlers y el resolver con las estrategias taggeadas por cada módulo.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.1.0
 *
 * @version 1.1.0
 */
class ExportServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(
            ExportFileServiceContract::class,
            OpenSpoutExportFileService::class
        );

        $this->app->singleton(
            ExportacionRepositoryContract::class,
            EloquentExportacionRepository::class
        );

        $this->app->singleton(ExportDataCommandHandler::class);
        $this->app->singleton(StoreExportacionHandler::class);

        $this->app->when(ListExportacionesForTableHandler::class)
            ->needs(ExportacionPaginatedTableQueryExecutorContract::class)
            ->give(EloquentExportacionPaginatedTableQueryExecutor::class);

        $this->app->when(GetExportacionesRecordsCountHandler::class)
            ->needs(GetExportacionesRecordsCountQueryExecutorContract::class)
            ->give(EloquentGetExportacionesRecordsCountQueryExecutor::class);

        $this->app->when(ListOldExportacionesHandler::class)
            ->needs(ListOldExportacionesQueryExecutorContract::class)
            ->give(EloquentListOldExportacionesQueryExecutor::class);

        $this->app->bind(ExportQueryResolver::class, function () {
            return new ExportQueryResolver(
                $this->app->tagged('export.query.strategies')
            );
        });
    }

    public function boot(): void
    {
        Bus::map([
            ExportDataCommand::class => ExportDataCommandHandler::class,
            StoreExportacionCommand::class => StoreExportacionHandler::class,
            CleanExportacionesCommand::class => CleanExportacionesHandler::class,
            DestroyExportacionCommand::class => DestroyExportacionHandler::class,
        ]);
    }
}
