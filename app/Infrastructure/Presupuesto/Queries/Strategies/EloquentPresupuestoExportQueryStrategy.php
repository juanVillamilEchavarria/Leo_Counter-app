<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */

namespace App\Infrastructure\Presupuesto\Queries\Strategies;

use App\Application\Exportacion\Contracts\Queries\Strategies\ExportQueryStrategyContract;
use App\Domains\Exportacion\Enums\ExportableTable;
use App\Infrastructure\Exportacion\Queries\Executors\Eloquent\Abstract\EloquentExportDataQuery;
use App\Infrastructure\Presupuesto\Queries\Executors\Eloquent\EloquentPresupuestoPaginatedTableQueryExecutor;
use App\Models\Presupuesto\Presupuesto;
use Illuminate\Database\Eloquent\Model;
use Override;

/**
 * Estrategia Eloquent de exportación para la tabla de presupuestos históricos (server-side).
 * Inyecta por composición el executor paginado existente, sin extenderlo.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.1.0
 *
 * @version 1.1.0
 */
final readonly class EloquentPresupuestoExportQueryStrategy extends EloquentExportDataQuery implements ExportQueryStrategyContract
{
    public function __construct(
        private EloquentPresupuestoPaginatedTableQueryExecutor $paginatedExecutor
    ) {
        parent::__construct($paginatedExecutor);
    }

    #[Override]
    public function supports(ExportableTable $table): bool
    {
        return $table === ExportableTable::PRESUPUESTOS;
    }

    /**
     * @return array<string>
     */
    protected function getHeaders(): array
    {
        return ['Periodo', 'Categoría', 'Monto', 'Usuario'];
    }

    /**
     * @param  Presupuesto  $presupuesto
     * @return array<string, mixed>
     */
    protected function toRow(Model $presupuesto): array
    {
        return [
            'Periodo' => $presupuesto->periodo?->format('Y-m') ?? $presupuesto->periodo ?? 'N/A',
            'Categoría' => $presupuesto->categoria?->nombre ?? 'N/A',
            'Monto' => $presupuesto->monto,
            'Usuario' => $presupuesto->user?->name ?? 'N/A',
        ];
    }
}
