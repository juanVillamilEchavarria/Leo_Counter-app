<?php

namespace App\Application\Cuenta\Contracts\Queries\Executors;

use App\Application\Cuenta\Contracts\Queries\ListCuentasQueryContract;
use App\Shared\Domain\Contracts\CollectionContract;

/**
 * Contract for Cuenta query executors
 */
interface CuentaQueryExecutorContract
{
    /**
     * Execute a Cuenta query
     * @param ListCuentasQueryContract $query
     * @return CollectionContract|int
     */
    public function execute(ListCuentasQueryContract $query): CollectionContract|int;
}