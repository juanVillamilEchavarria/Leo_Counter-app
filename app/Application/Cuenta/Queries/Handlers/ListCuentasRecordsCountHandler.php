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

use App\Application\Cuenta\Contracts\Queries\Executors\GetCuentaRecordsCountQueryExecutorContract;
use App\Application\Cuenta\Queries\ListCuentasRecordsCountQuery;

/**
 * Handler for getting the count of cuenta records
 */
final readonly class ListCuentasRecordsCountHandler
{
    public function __construct(
        private GetCuentaRecordsCountQueryExecutorContract $executor,
    ) {}

    public function __invoke(ListCuentasRecordsCountQuery $query): int
    {
        return $this->executor->execute();
    }
}
