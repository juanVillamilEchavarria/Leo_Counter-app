<?php

namespace App\Infrastructure\Cuenta\Queries\Executors\Eloquent;

use App\Application\Cuenta\Contracts\Queries\Executors\CuentaQueryExecutorContract;
use App\Application\Cuenta\Contracts\Queries\ListCuentasQueryContract;
use App\Shared\Domain\Contracts\CollectionContract;
use App\Models\Cuenta\Cuenta;
use App\Shared\Infrastructure\Framework\Laravel\Collections\LaravelCollection;

/**
 * Executor for listing all cuentas with details using Eloquent
 */
final readonly class EloquentListAllCuentasWithDetailsExecutor implements CuentaQueryExecutorContract
{
    private function relations(): array
    {
        return [
            'propietario',
            'tipo_cuenta',
        ];
    }

    public function execute(ListCuentasQueryContract $query): CollectionContract
    {
        return new LaravelCollection(Cuenta::with($this->relations())->get());
    }
}