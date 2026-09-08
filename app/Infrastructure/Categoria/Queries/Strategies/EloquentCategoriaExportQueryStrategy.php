<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */

namespace App\Infrastructure\Categoria\Queries\Strategies;

use App\Application\Exportacion\Contracts\Queries\Strategies\ExportQueryStrategyContract;
use App\Domains\Exportacion\Enums\ExportableTable;
use App\Infrastructure\Exportacion\Queries\Executors\Eloquent\Abstract\EloquentExportClientSideTableQuery;
use App\Models\Categoria\Categoria;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Override;

/**
 * Estrategia Eloquent de exportación para la tabla de categorías (client-side).
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.1.0
 *
 * @version 1.1.0
 */
final readonly class EloquentCategoriaExportQueryStrategy extends EloquentExportClientSideTableQuery implements ExportQueryStrategyContract
{
    #[Override]
    public function supports(ExportableTable $table): bool
    {
        return $table === ExportableTable::CATEGORIAS;
    }

    #[Override]
    protected function baseModelQuery(): Model|Builder
    {
        return Categoria::with(['tipo_movimiento']);
    }

    /**
     * @return array<string>
     */
    protected function getHeaders(): array
    {
        return ['Nombre', 'Tipo de Movimiento', 'Descripción', 'Es Fijo'];
    }

    /**
     * @param  Categoria  $categoria
     * @return array<string, mixed>
     */
    protected function toRow(Model $categoria): array
    {
        return [
            'Nombre' => $categoria->nombre,
            'Tipo de Movimiento' => $categoria->tipo_movimiento?->tipo_movimiento ?? 'N/A',
            'Descripción' => $categoria->descripcion ?? '',
            'Es Fijo' => $categoria->es_fijo ? 'Sí' : 'No',
        ];
    }
}
