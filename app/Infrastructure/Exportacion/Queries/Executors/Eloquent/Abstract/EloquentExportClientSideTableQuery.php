<?php

namespace App\Infrastructure\Exportacion\Queries\Executors\Eloquent\Abstract;

use App\Application\Exportacion\Contracts\Queries\Strategies\ExportQueryStrategyContract;
use App\Application\Exportacion\DTOs\ExportDataResultDTO;
use App\Application\Exportacion\Exceptions\ExportLimitExceededException;
use App\Application\Exportacion\Queries\ExportDataQuery;
use App\Domains\Exportacion\Enums\ExportableTable;
use App\Domains\Exportacion\Enums\ExportNumericRules;
use App\Shared\Infrastructure\Framework\Laravel\Collections\LaravelCollection;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model;
use Override;

/**
 * Estrategia Eloquent de exportación para la tabla de cuentas (client-side).
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.1.0
 *
 * @version 1.1.0
 */
abstract readonly class EloquentExportClientSideTableQuery implements ExportQueryStrategyContract
{
    abstract public function supports(ExportableTable $table): bool;

    #[Override]
    public function export(ExportDataQuery $query): ExportDataResultDTO
    {
        $builder = $this->baseModelQuery();

        if ($query->onlyCurrentPage && ! empty($query->visibleIds)) {
            $builder->whereIn('id', $query->visibleIds);
        }
        if ($builder->count() > ExportNumericRules::MAX_RECORDS->value) {
            throw new ExportLimitExceededException;
        }

        $items = $builder->get()->all();

        $rows = LaravelCollection::make(
            array_map(fn (Model $model) => $this->toRow($model), $items)
        );

        return new ExportDataResultDTO(
            headers: $this->getHeaders(),
            rows: $rows
        );
    }

    /**
     * Devuelve la query base del modelo de Eloquent para la tabla a exportar.
     */
    abstract protected function baseModelQuery(): Model|EloquentBuilder;

    /**
     * Devuelve los headers de la tabla de exportación.
     *
     * @return array<string>
     */
    abstract protected function getHeaders(): array;

    /**
     * mapea un modelo de Eloquent a un array asociativo que representa una fila de datos para exportar.
     *
     * @return array<string, mixed>
     */
    abstract protected function toRow(Model $model): array;
}
