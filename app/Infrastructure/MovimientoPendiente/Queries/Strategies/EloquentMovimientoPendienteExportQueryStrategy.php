<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */

namespace App\Infrastructure\MovimientoPendiente\Queries\Strategies;

use App\Application\Exportacion\Contracts\Queries\Strategies\ExportQueryStrategyContract;
use App\Domains\Exportacion\Enums\ExportableTable;
use App\Infrastructure\Exportacion\Queries\Executors\Eloquent\Abstract\EloquentExportClientSideTableQuery;
use App\Models\MovimientoPendiente\MovimientoPendiente;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Override;

/**
 * Estrategia Eloquent de exportación para la tabla de movimientos pendientes (client-side).
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.1.0
 *
 * @version 1.1.0
 */
final readonly class EloquentMovimientoPendienteExportQueryStrategy extends EloquentExportClientSideTableQuery implements ExportQueryStrategyContract
{
    #[Override]
    public function supports(ExportableTable $table): bool
    {
        return $table === ExportableTable::MOVIMIENTOS_PENDIENTES;
    }

    #[Override]
    protected function baseModelQuery(): Model|Builder
    {
        return MovimientoPendiente::with(['cuenta', 'categoria', 'tipo_movimiento', 'movimiento_fijo']);
    }

    /**
     * @return array<string>
     */
    protected function getHeaders(): array
    {
        return ['Nombre', 'Cuenta', 'Categoría', 'Tipo', 'Monto', 'Fecha Programada', 'Estado'];
    }

    /**
     * @param  MovimientoPendiente  $movimientoPendiente
     * @return array<string, mixed>
     */
    protected function toRow(Model $movimientoPendiente): array
    {
        return [
            'Nombre' => $movimientoPendiente->nombre,
            'Cuenta' => $movimientoPendiente->cuenta?->nombre ?? 'N/A',
            'Categoría' => $movimientoPendiente->categoria?->nombre ?? 'N/A',
            'Tipo' => $movimientoPendiente->tipo_movimiento?->tipo_movimiento ?? 'N/A',
            'Monto' => $movimientoPendiente->monto,
            'Fecha Programada' => $movimientoPendiente->fecha_programada,
            'Estado' => $movimientoPendiente->estado ?? 'N/A',
        ];
    }
}
