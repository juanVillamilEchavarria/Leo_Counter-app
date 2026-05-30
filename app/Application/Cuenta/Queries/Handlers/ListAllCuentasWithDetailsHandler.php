<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
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
        private CuentaQueryExecutorContract $listCuentasQueryExecutor,
    ) {}

    /**
     * Handle the query to list all cuentas with details
     * @param ListAllCuentasWithDetailsQuery $query
     * @return CollectionContract
     */
    public function __invoke(ListAllCuentasWithDetailsQuery $query): CollectionContract
    {
        return $this->listCuentasQueryExecutor->execute($query);
    }
}
