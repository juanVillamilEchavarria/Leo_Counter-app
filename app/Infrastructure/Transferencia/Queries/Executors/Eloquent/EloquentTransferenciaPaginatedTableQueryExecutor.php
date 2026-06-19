<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
namespace App\Infrastructure\Transferencia\Queries\Executors\Eloquent;

use App\Shared\Infrastructure\Queries\Executors\EloquentPaginatedTableQueryExecutor;
use App\Application\Transferencia\Contracts\Queries\Executors\TransferenciaPaginatedTableQueryExecutorContract;
use App\Models\Transferencia\Transferencia;

/**
 * Executor Eloquent para paginación de tabla de transferencias (server side).
 * Reutiliza la lógica común de EloquentPaginatedTableQueryExecutor y declara relaciones/columnas específicas.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.1
 * @version 1.0.1
 */
final readonly class EloquentTransferenciaPaginatedTableQueryExecutor extends EloquentPaginatedTableQueryExecutor implements TransferenciaPaginatedTableQueryExecutorContract
{
    protected function model(): string
    {
       return Transferencia::class;
    }

    protected function modelRelations(): array
    {
        return ['cuentaOrigen', 'cuentaDestino'];
    }

    protected function searchColumns(): array
    {
        return [
            'cuentaOrigen' => [
                'cuentas.nombre'
            ],
            'cuentaDestino' => [
                'cuentas.nombre'
            ],
            'monto',
            'descripcion',
            'fecha'
        ];
    }

    protected function modelSorteableRelations(): array
    {
        return [
            'cuentaOrigen'=>[
                'relation'=> 'cuentaOrigen',
                'column'=> 'cuentas.nombre'
            ],
            'cuentaDestino'=>[
                'relation'=> 'cuentaDestino',
                'column'=> 'cuentas.nombre'
            ]
        ];
    }
}
