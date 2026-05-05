<?php

namespace App\Infrastructure\Cuenta\Queries\Executors\Eloquent;

use App\Application\Cuenta\Contracts\Queries\Executors\CuentaQueryExecutorContract;
use App\Application\Cuenta\Contracts\Queries\ListCuentasQueryContract;
use App\Shared\Domain\Contracts\CollectionContract;
use App\Models\Cuenta\Cuenta;
use App\Shared\Infrastructure\Framework\Laravel\Collections\LaravelCollection;
use Illuminate\Database\Query\Builder;

/**
 * QueryExecutor for listing all cuentas with details using Eloquent
 */
final readonly class EloquentListAllCuentasWithDetailsQueryExecutor implements CuentaQueryExecutorContract
{
    private function relations(): array
{
    return [
        'propietario:id,nombre,apellido',
        'tipo_cuenta:id,tipo_cuenta',
    ];
}

    public function execute(ListCuentasQueryContract $query): CollectionContract
    {
        return new LaravelCollection(Cuenta::with($this->relations())->get());
    }
}