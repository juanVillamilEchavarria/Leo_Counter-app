<?php

namespace App\Infrastructure\Movimiento\Queries\Executors\Eloquent;

use App\Shared\Infrastructure\Queries\Executors\EloquentPaginatedTableQueryExecutor;
use App\Application\Movimiento\Contracts\Queries\Executors\MovimientoPaginatedTableQueryExecutorContract;
use App\Models\Movimiento\Movimiento;
use Override;

/**
 * Executor Eloquent para paginación de tabla de movimientos (server side).
 * Basado en el patrón compartido de EloquentPaginatedTableQueryExecutor.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class EloquentMovimientoPaginatedTableQueryExecutor extends EloquentPaginatedTableQueryExecutor implements MovimientoPaginatedTableQueryExecutorContract
{
    #[Override]
    protected function model(): string
    {
       return Movimiento::class;
    }

    #[Override]
    protected function modelRelations(): array
    {
        return ['cuenta', 'categoria', 'tipo_movimiento'];
    }

    #[Override]
    protected function searchColumns(): array
    {
        return [
            'cuenta' => [
                'cuentas.nombre'
            ],
            'categoria' => [
                'categorias.nombre'
            ],
            'tipo_movimiento' => [
                'tipo_movimientos.tipo_movimiento'
            ],
            'nombre',
            'descripcion',
            'monto',
            'fecha'
        ];
    }

    #[Override]
    protected function modelSorteableRelations(): array
    {
        return [
            'cuenta'=>[
                'relation'=> 'cuenta',
                'column'=> 'cuentas.nombre'
            ],
            'tipo_movimiento'=>[
                'relation'=> 'tipo_movimiento',
                'column'=> 'tipo_movimientos.tipo_movimiento'
            ],
            'categoria'=>[
                'relation'=> 'categoria',
                'column'=> 'categorias.nombre'
            ]
        ];
    }
}
