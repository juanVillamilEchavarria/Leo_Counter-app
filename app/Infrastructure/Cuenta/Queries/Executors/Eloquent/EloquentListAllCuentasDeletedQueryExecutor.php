<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Infrastructure\Cuenta\Queries\Executors\Eloquent;

use App\Application\Cuenta\Contracts\Queries\Executors\CuentaQueryExecutorContract;
use App\Application\Cuenta\Contracts\Queries\ListCuentasQueryContract;
use App\Models\Cuenta\Cuenta;
use App\Shared\Domain\Contracts\CollectionContract;
use App\Shared\Infrastructure\Framework\Laravel\Collections\LaravelCollection;

/**
 * Query executor Eloquent para listar cuentas eliminadas.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Infrastructure\Cuenta\Queries\Executors\Eloquent
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class EloquentListAllCuentasDeletedQueryExecutor implements CuentaQueryExecutorContract
{
    public function execute(ListCuentasQueryContract $query): CollectionContract
    {
        return LaravelCollection::make(
            Cuenta::onlyTrashed()
                ->with([
                    'propietario:id,nombre,apellido',
                    'tipo_cuenta:id,tipo_cuenta',
                ])
                ->get()
        );
    }
}
