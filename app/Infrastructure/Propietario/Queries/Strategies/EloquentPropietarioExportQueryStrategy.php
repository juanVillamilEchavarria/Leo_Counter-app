<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */

namespace App\Infrastructure\Propietario\Queries\Strategies;

use App\Application\Exportacion\Contracts\Queries\Strategies\ExportQueryStrategyContract;
use App\Domains\Exportacion\Enums\ExportableTable;
use App\Infrastructure\Exportacion\Queries\Executors\Eloquent\Abstract\EloquentExportClientSideTableQuery;
use App\Models\Propietario\Propietario;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Override;

/**
 * Estrategia Eloquent de exportación para la tabla de propietarios (client-side).
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.1.0
 *
 * @version 1.1.0
 */
final readonly class EloquentPropietarioExportQueryStrategy extends EloquentExportClientSideTableQuery implements ExportQueryStrategyContract
{
    #[Override]
    public function supports(ExportableTable $table): bool
    {
        return $table === ExportableTable::PROPIETARIOS;
    }

    #[Override]
    protected function baseModelQuery(): Model|Builder
    {
        return Propietario::query();
    }

    /**
     * @return array<string>
     */
    protected function getHeaders(): array
    {
        return ['Nombre', 'Apellido', 'Email', 'Teléfono'];
    }

    /**
     * @param  Propietario  $propietario
     * @return array<string, mixed>
     */
    protected function toRow(Model $propietario): array
    {
        return [
            'Nombre' => $propietario->nombre,
            'Apellido' => $propietario->apellido,
            'Email' => $propietario->email,
            'Teléfono' => $propietario->telefono ?? '',
        ];
    }
}
