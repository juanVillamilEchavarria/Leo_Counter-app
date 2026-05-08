<?php

namespace App\Infrastructure\Presupuesto\Queries\Executors\Eloquent;

use App\Shared\Infrastructure\Queries\Executors\EloquentPaginatedTableQueryExecutor;
use App\Application\Presupuesto\Contracts\Queries\Executors\PresupuestoQueryExecutorContract;
use App\Application\Presupuesto\Contracts\Queries\Executors\PresupuestoPaginatedTableQueryExecutorContract;
use App\Models\Presupuesto\Presupuesto;
use Override;
/**
 * Clase que se encarga de listar los presupuestos para los filtros de una tabla (server side)
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 * @package App\Shared\Infrastructure\Queries\Executors
 */

final readonly class EloquentPresupuestoPaginatedTableQueryExecutor extends EloquentPaginatedTableQueryExecutor implements PresupuestoPaginatedTableQueryExecutorContract {
    #[Override]
    protected function model(): string
    {
       return Presupuesto::class;
    }
    #[Override]
    protected function modelRelations(): array
    {
        return ['categoria', 'user'];
    }
    #[Override]
    protected function searchColumns(): array
    {
        return [
        'categoria' => [
            'categorias.nombre'
        ],
        'user' => [
            'users.name'
        ]
    ];
    }
    #[Override]
    protected function modelSorteableRelations(): array
    {
        return [
        'user'=>[
            'relation'=> 'user',
            'column'=> 'user.name'
        ],
        'categoria'=>[
            'relation'=> 'categoria',
            'column'=> 'categorias.nombre'
        ]
    ];
    }

}
