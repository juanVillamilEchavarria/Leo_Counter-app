<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */

namespace App\Providers\Auditoria;

use App\Application\Auditoria\Contracts\Queries\Executors\AuditoriaPaginatedTableQueryExecutorContract;
use App\Application\Auditoria\Contracts\Queries\Executors\ListOldAuditoriasQueryExecutorContract;
use App\Application\Auditoria\Queries\Handlers\ListAuditoriaForTableHandler;
use App\Application\Auditoria\Queries\Handlers\ListOldAuditoriasHandler;
use App\Domains\Auditoria\Contracts\Repositories\AuditoriaRepositoryContract;
use App\Infrastructure\Auditoria\Persistence\Repositories\EloquentAuditoriaRepository;
use App\Infrastructure\Auditoria\Queries\Executors\Eloquent\EloquentAuditoriaPaginatedTableQueryExecutor;
use App\Infrastructure\Auditoria\Queries\Executors\Eloquent\EloquentListOldAuditoriasQueryExecutor;
use App\Infrastructure\Auditoria\Queries\Strategies\EloquentAuditoriaExportQueryStrategy;
use Illuminate\Support\ServiceProvider;

/**
 * Service provider para bindings de Auditoría (repositorios y ejecutores de consultas).
 * Registra las implementaciones Eloquent para los contratos de auditoría.
 */
final class AuditoriaServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->tag([
            EloquentAuditoriaExportQueryStrategy::class,
        ], 'export.query.strategies');

        $this->app->when(ListAuditoriaForTableHandler::class)
            ->needs(AuditoriaPaginatedTableQueryExecutorContract::class)
            ->give(EloquentAuditoriaPaginatedTableQueryExecutor::class);

        $this->app->singleton(AuditoriaPaginatedTableQueryExecutorContract::class, EloquentAuditoriaPaginatedTableQueryExecutor::class);
        $this->app->singleton(AuditoriaRepositoryContract::class, EloquentAuditoriaRepository::class);

        $this->app->when(ListOldAuditoriasHandler::class)
            ->needs(ListOldAuditoriasQueryExecutorContract::class)
            ->give(EloquentListOldAuditoriasQueryExecutor::class);

        // Binding para obtener el conteo total de auditorías
        $this->app->bind(
            \App\Application\Auditoria\Contracts\Queries\Executors\GetAuditoriaRecordsCountQueryExecutorContract::class,
            \App\Infrastructure\Auditoria\Queries\Executors\Eloquent\EloquentGetAuditoriaRecordsCountQueryExecutor::class
        );
    }

    public function boot(): void
    {
        //
    }
}
