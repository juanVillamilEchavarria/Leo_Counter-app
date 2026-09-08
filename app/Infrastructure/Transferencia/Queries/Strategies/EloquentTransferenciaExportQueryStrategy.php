<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */

namespace App\Infrastructure\Transferencia\Queries\Strategies;

use App\Application\Exportacion\Contracts\Queries\Strategies\ExportQueryStrategyContract;
use App\Domains\Exportacion\Enums\ExportableTable;
use App\Infrastructure\Exportacion\Queries\Executors\Eloquent\Abstract\EloquentExportDataQuery;
use App\Infrastructure\Transferencia\Queries\Executors\Eloquent\EloquentTransferenciaPaginatedTableQueryExecutor;
use App\Models\Transferencia\Transferencia;
use Illuminate\Database\Eloquent\Model;
use Override;

/**
 * Estrategia Eloquent de exportación para la tabla de transferencias (server-side).
 * Inyecta por composición el executor paginado existente, sin extenderlo.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.1.0
 *
 * @version 1.1.0
 */
final readonly class EloquentTransferenciaExportQueryStrategy extends EloquentExportDataQuery implements ExportQueryStrategyContract
{
    public function __construct(
        private EloquentTransferenciaPaginatedTableQueryExecutor $paginatedExecutor
    ) {
        parent::__construct($paginatedExecutor);
    }

    #[Override]
    public function supports(ExportableTable $table): bool
    {
        return $table === ExportableTable::TRANSFERENCIAS;
    }

    /**
     * @return array<string>
     */
    protected function getHeaders(): array
    {
        return ['Fecha', 'Cuenta Origen', 'Cuenta Destino', 'Monto', 'Descripción'];
    }

    /**
     * @param  Transferencia  $transferencia
     * @return array<string, mixed>
     */
    protected function toRow(Model $transferencia): array
    {
        return [
            'Fecha' => $transferencia->fecha,
            'Cuenta Origen' => $transferencia->cuentaOrigen?->nombre ?? 'N/A',
            'Cuenta Destino' => $transferencia->cuentaDestino?->nombre ?? 'N/A',
            'Monto' => $transferencia->monto,
            'Descripción' => $transferencia->descripcion ?? '',
        ];
    }
}
