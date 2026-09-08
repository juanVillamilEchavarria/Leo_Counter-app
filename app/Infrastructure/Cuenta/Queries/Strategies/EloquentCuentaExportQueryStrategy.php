<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */

namespace App\Infrastructure\Cuenta\Queries\Strategies;

use App\Application\Exportacion\Contracts\Queries\Strategies\ExportQueryStrategyContract;
use App\Application\Exportacion\DTOs\ExportDataResultDTO;
use App\Application\Exportacion\Queries\ExportDataQuery;
use App\Domains\Exportacion\Enums\ExportableTable;
use App\Infrastructure\Exportacion\Queries\Executors\Eloquent\Abstract\EloquentExportClientSideTableQuery;
use App\Models\Cuenta\Cuenta;
use App\Shared\Infrastructure\Framework\Laravel\Collections\LaravelCollection;
use Illuminate\Database\Eloquent\Builder;
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
final readonly class EloquentCuentaExportQueryStrategy extends EloquentExportClientSideTableQuery implements ExportQueryStrategyContract
{
    #[Override]
    public function supports(ExportableTable $table): bool
    {
        return $table === ExportableTable::CUENTAS;
    }

    #[Override]
    protected function baseModelQuery(): Model|Builder
    {
        return Cuenta::with(['propietario', 'tipo_cuenta']);
    }

    /**
     * @return array<string>
     */
    protected function getHeaders(): array
    {
        return ['Nombre', 'Saldo Inicial', 'Saldo Actual', 'Tipo', 'Propietario', 'Notas'];
    }

    /**
     * @param Cuenta $cuenta
     * @return array<string, mixed>
     */
    protected function toRow(Model $cuenta): array
    {
        return [
            'Nombre' => $cuenta->nombre,
            'Saldo Inicial' => $cuenta->saldo_inicial,
            'Saldo Actual' => $cuenta->saldo_actual,
            'Tipo' => $cuenta->tipo_cuenta?->tipo_cuenta ?? 'N/A',
            'Propietario' => $cuenta->propietario
                ? trim($cuenta->propietario->nombre.' '.$cuenta->propietario->apellido)
                : 'N/A',
            'Notas' => $cuenta->notas ?? '',
        ];
    }
}
