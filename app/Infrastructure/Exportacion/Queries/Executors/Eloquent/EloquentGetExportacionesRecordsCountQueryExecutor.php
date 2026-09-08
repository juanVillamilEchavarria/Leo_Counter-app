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

use App\Application\Exportacion\Contracts\Queries\Executors\GetExportacionesRecordsCountQueryExecutorContract;
use App\Models\Exportacion\Exportacion;
use Override;

/**
 * Executor Eloquent que obtiene el conteo total de exportaciones.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.1.0
 *
 * @version 1.1.0
 */
final readonly class EloquentGetExportacionesRecordsCountQueryExecutor implements GetExportacionesRecordsCountQueryExecutorContract
{
    #[Override]
    public function execute(): int
    {
        return Exportacion::query()->count();
    }
}
