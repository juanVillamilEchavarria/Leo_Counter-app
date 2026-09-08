<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */

namespace App\Infrastructure\Exportacion\Queries\Executors\Eloquent;

use App\Application\Exportacion\Contracts\Queries\Executors\ExportacionPaginatedTableQueryExecutorContract;
use App\Models\Exportacion\Exportacion;
use App\Shared\Infrastructure\Queries\Executors\EloquentPaginatedTableQueryExecutor;
use Override;

/**
 * Executor Eloquent para la paginación de la tabla de exportaciones (server-side).
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.1.0
 *
 * @version 1.1.0
 */
final readonly class EloquentExportacionPaginatedTableQueryExecutor extends EloquentPaginatedTableQueryExecutor implements ExportacionPaginatedTableQueryExecutorContract
{
    #[Override]
    protected function model(): string
    {
        return Exportacion::class;
    }

    #[Override]
    protected function modelRelations(): array
    {
        return ['user'];
    }

    #[Override]
    protected function searchColumns(): array
    {
        return [
            'user' => [
                'users.name',
                'users.email',
            ],
            'table',
            'format',
            'filename',
        ];
    }

    #[Override]
    protected function modelSorteableRelations(): array
    {
        return [
            'user' => [
                'relation' => 'user',
                'column' => 'users.name',
            ],
        ];
    }
}
