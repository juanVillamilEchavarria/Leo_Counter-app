<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */

namespace App\Infrastructure\MovimientoFijo\Queries\Strategies;

use App\Application\Exportacion\Contracts\Queries\Strategies\ExportQueryStrategyContract;
use App\Domains\Exportacion\Enums\ExportableTable;
use App\Infrastructure\Exportacion\Queries\Executors\Eloquent\Abstract\EloquentExportClientSideTableQuery;
use App\Models\MovimientoFijo\MovimientoFijo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Override;

/**
 * Estrategia Eloquent de exportación para la tabla de movimientos fijos (client-side).
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.1.0
 *
 * @version 1.1.0
 */
final readonly class EloquentMovimientoFijoExportQueryStrategy extends EloquentExportClientSideTableQuery implements ExportQueryStrategyContract
{
    #[Override]
    public function supports(ExportableTable $table): bool
    {
        return $table === ExportableTable::MOVIMIENTOS_FIJOS;
    }

    #[Override]
    protected function baseModelQuery(): Model|Builder
    {
        return MovimientoFijo::with(['cuenta', 'categoria', 'tipo_movimiento', 'frecuencia_movimiento']);
    }

    /**
     * @return array<string>
     */
    protected function getHeaders(): array
    {
        return ['Nombre', 'Cuenta', 'Categoría', 'Tipo', 'Monto', 'Fecha Próximo Pago', 'Frecuencia', 'Descripción'];
    }

    /**
     * @param  MovimientoFijo  $movimientoFijo
     * @return array<string, mixed>
     */
    protected function toRow(Model $movimientoFijo): array
    {
        return [
            'Nombre' => $movimientoFijo->nombre,
            'Cuenta' => $movimientoFijo->cuenta?->nombre ?? 'N/A',
            'Categoría' => $movimientoFijo->categoria?->nombre ?? 'N/A',
            'Tipo' => $movimientoFijo->tipo_movimiento?->tipo_movimiento ?? 'N/A',
            'Monto' => $movimientoFijo->monto,
            'Fecha Próximo Pago' => $movimientoFijo->fecha_proximo,
            'Frecuencia' => $movimientoFijo->frecuencia_movimiento?->frecuencia_movimiento ?? 'N/A',
            'Descripción' => $movimientoFijo->descripcion ?? '',
        ];
    }
}
