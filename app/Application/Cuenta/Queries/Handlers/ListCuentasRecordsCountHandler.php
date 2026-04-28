<?php

namespace App\Application\Cuenta\Queries\Handlers;

use App\Application\Cuenta\Contracts\Queries\Executors\CuentaQueryExecutorContract;
use App\Application\Cuenta\Queries\ListCuentasRecordsCountQuery;

/**
 * Handler for getting the count of cuenta records
 */
final readonly class ListCuentasRecordsCountHandler
{
    public function __construct(
        private CuentaQueryExecutorContract $executor,
    ) {}

    public function __invoke(ListCuentasRecordsCountQuery $query): int
    {
        return $this->executor->execute($query);
    }
}