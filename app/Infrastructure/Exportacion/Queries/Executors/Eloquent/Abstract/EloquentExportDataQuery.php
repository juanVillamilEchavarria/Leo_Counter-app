<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */

namespace App\Infrastructure\Exportacion\Queries\Executors\Eloquent\Abstract;

use App\Application\Exportacion\Contracts\Queries\Strategies\ExportQueryStrategyContract;
use App\Application\Exportacion\DTOs\ExportDataResultDTO;
use App\Application\Exportacion\Exceptions\ExportLimitExceededException;
use App\Application\Exportacion\Queries\ExportDataQuery;
use App\Application\Exportacion\Queries\ExportTableQuery;
use App\Domains\Exportacion\Enums\ExportableTable;
use App\Domains\Exportacion\Enums\ExportNumericRules;
use App\Shared\Infrastructure\Framework\Laravel\Collections\LaravelCollection;
use App\Shared\Infrastructure\Queries\Executors\EloquentPaginatedTableQueryExecutor;
use Illuminate\Database\Eloquent\Model;

/**
 * Clase padre que encapsula la logica compartida para exportar la data de una tabla de la base de datos
 *
 * @author Juan Esteban Villamil Echavarria
 */
abstract readonly class EloquentExportDataQuery implements ExportQueryStrategyContract
{
    public function __construct(
        private EloquentPaginatedTableQueryExecutor $filterExecutor
    ) {}

    /**
     * {@inheritDoc}
     */
    abstract public function supports(ExportableTable $table): bool;

    /**
     * {@inheritDoc}
     */
    public function export(ExportDataQuery $query): ExportDataResultDTO
    {
        $filters = $query->filters ?? new ExportTableQuery;
        $builder = $this->filterExecutor->buildQueryForExport($filters);

        if ($query->onlyCurrentPage) {
            $perPage = $filters->perPage ?? 20;
            $page = $filters->page ?? 1;

            $paginator = $builder->paginate($perPage, ['*'], 'page', $page);
            $items = $paginator->items();
        } else {
            if ($builder->count() > ExportNumericRules::MAX_RECORDS->value) {
                throw new ExportLimitExceededException;
            }

            $items = $builder->get()->all();
        }

        $rows = LaravelCollection::make(
            array_map(fn (Model $model) => $this->toRow($model), $items)
        );

        return new ExportDataResultDTO(
            headers: $this->getHeaders(),
            rows: $rows
        );
    }

    /**
     * Devuelve el modelo mapeado a un arreglo
     */
    abstract protected function toRow(Model $model): array;

    /**
     * Devuelve los headers de la tabla
     */
    abstract protected function getHeaders(): array;
}
