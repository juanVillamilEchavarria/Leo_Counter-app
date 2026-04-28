<?php

namespace App\Infrastructure\Cuenta\Queries\Executors\Eloquent;

use App\Application\Cuenta\Contracts\Queries\Executors\CuentaQueryExecutorContract;
use App\Application\Cuenta\Contracts\Queries\ListCuentasQueryContract;
use App\Models\Cuenta\Cuenta;

/**
 * Executor for getting the count of cuenta records using Eloquent
 */
final readonly class EloquentListCuentasRecordsCountExecutor implements CuentaQueryExecutorContract
{
    public function execute(ListCuentasQueryContract $query): int
    {
        return Cuenta::count();
    }
}