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

use App\Application\Exportacion\Contracts\Queries\Executors\ListOldExportacionesQueryExecutorContract;
use App\Domains\Exportacion\Aggregate\Exportacion;
use App\Domains\Exportacion\Enums\ExportableTable;
use App\Domains\Exportacion\Enums\ExportFormat;
use App\Domains\Exportacion\ValueObjects\ExportacionId;
use App\Domains\Usuario\ValueObjects\UsuarioId;
use App\Models\Exportacion\Exportacion as ExportacionModel;
use App\Shared\Domain\Contracts\CollectionContract;
use App\Shared\Infrastructure\Framework\Laravel\Collections\LaravelCollection;
use Override;

/**
 * Executor Eloquent que obtiene las exportaciones con 6 meses o más de
 * antigüedad y las devuelve como una colección de agregados.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.1.0
 *
 * @version 1.1.0
 */
final readonly class EloquentListOldExportacionesQueryExecutor implements ListOldExportacionesQueryExecutorContract
{
    #[Override]
    public function execute(): CollectionContract
    {
        $records = ExportacionModel::query()
            ->where('created_at', '<=', now()->subMonths(6))
            ->get();

        $aggregates = $records->map(fn (ExportacionModel $record) => Exportacion::reconstitute(
            id: new ExportacionId($record->id),
            userId: new UsuarioId($record->user_id),
            table: ExportableTable::from($record->table),
            format: ExportFormat::from($record->format),
            recordsCount: $record->records_count,
            filename: $record->filename,
            filters: $this->decodeFilters($record->filters),
        ));

        return new LaravelCollection($aggregates);
    }

    private function decodeFilters(mixed $filters): ?array
    {
        if ($filters === null) {
            return null;
        }

        if (is_array($filters)) {
            return $filters;
        }

        if (is_string($filters)) {
            $decoded = json_decode($filters, true);

            return $decoded ?: [];
        }

        return null;
    }
}
