<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */

namespace App\Infrastructure\Movimiento\Queries\Strategies;

use App\Application\Exportacion\Contracts\Queries\Strategies\ExportQueryStrategyContract;
use App\Domains\Exportacion\Enums\ExportableTable;
use App\Infrastructure\Exportacion\Queries\Executors\Eloquent\Abstract\EloquentExportDataQuery;
use App\Infrastructure\Movimiento\Queries\Executors\Eloquent\EloquentMovimientoPaginatedTableQueryExecutor;
use App\Models\Movimiento\Movimiento;
use Illuminate\Database\Eloquent\Model;
use Override;

/**
 * Estrategia Eloquent de exportación para la tabla de movimientos (server-side).
 * Inyecta por composición el executor paginado existente, sin extenderlo.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.1.0
 *
 * @version 1.1.0
 */
final readonly class EloquentMovimientoExportQueryStrategy extends EloquentExportDataQuery implements ExportQueryStrategyContract
{
    public function __construct(
        private EloquentMovimientoPaginatedTableQueryExecutor $paginatedExecutor
    ) {
        parent::__construct($paginatedExecutor);
    }

    #[Override]
    public function supports(ExportableTable $table): bool
    {
        return $table === ExportableTable::MOVIMIENTOS;
    }

    /**
     * @return array<string>
     */
    protected function getHeaders(): array
    {
        return ['Fecha', 'Cuenta', 'Categoría', 'Tipo', 'Nombre', 'Descripción', 'Monto'];
    }

    /**
     * @param Movimiento $movimiento
     * @return array<string, mixed>
     */
    protected function toRow(Model $movimiento): array
    {
        return [
            'Fecha' => $movimiento->fecha,
            'Cuenta' => $movimiento->cuenta?->nombre ?? 'N/A',
            'Categoría' => $movimiento->categoria?->nombre ?? 'N/A',
            'Tipo' => $movimiento->tipo_movimiento?->tipo_movimiento ?? 'N/A',
            'Nombre' => $movimiento->nombre,
            'Descripción' => $movimiento->descripcion ?? '',
            'Monto' => $movimiento->monto,
        ];
    }
}
