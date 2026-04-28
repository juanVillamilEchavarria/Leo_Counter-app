<?php

namespace App\Application\Cuenta\Queries\Handlers;

use App\Application\Cuenta\Contracts\Queries\Executors\CuentaQueryExecutorContract;
use App\Application\Cuenta\Queries\ListAllCuentasWithDetailsQuery;
use App\Shared\Domain\Contracts\CollectionContract;

/**
 * Handler for listing all cuentas with details
 */
final readonly class ListAllCuentasWithDetailsHandler
{
    public function __construct(
        private CuentaQueryExecutorContract $listCuentasExecutor,
    ) {}

    /**
     * Handle the query to list all cuentas with details
     * @param ListAllCuentasWithDetailsQuery $query
     * @return CollectionContract
     */
    public function __invoke(ListAllCuentasWithDetailsQuery $query): CollectionContract
    {
        return $this->listCuentasExecutor->execute($query);
    }
}