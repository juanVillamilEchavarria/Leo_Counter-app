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
use Override;

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
    #[Override]
    protected function model(): string
    {
       return Transferencia::class;
    }

    #[Override]
    protected function modelRelations(): array
    {
        return ['cuentaEnviadora', 'cuentaReceptora'];
    }

    #[Override]
    protected function searchColumns(): array
    {
        return [
            'cuentaEnviadora' => [
                'cuentas.nombre'
            ],
            'cuentaReceptora' => [
                'cuentas.nombre'
            ],
            'monto',
            'descripcion',
            'fecha'
        ];
    }

    #[Override]
    protected function modelSorteableRelations(): array
    {
        return [
            'cuentaEnviadora'=>[
                'relation'=> 'cuentaEnviadora',
                'column'=> 'cuentas.nombre'
            ],
            'cuentaReceptora'=>[
                'relation'=> 'cuentaReceptora',
                'column'=> 'cuentas.nombre'
            ]
        ];
    }
}
