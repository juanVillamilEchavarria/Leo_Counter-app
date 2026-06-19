<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
namespace App\Application\Transferencia\Queries\Handlers;

use App\Application\Transferencia\Contracts\Queries\Executors\TransferenciaQueryExecutorContract;
use App\Application\Transferencia\Queries\ListTransferenciasQuery;
use App\Shared\Domain\Contracts\CollectionContract;

/**
 * Manejador para listar todas las transferencias.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.1
 * @version 1.0.1
 */
final readonly class ListTransferenciasHandler
{
    public function __construct(
        private TransferenciaQueryExecutorContract $queryExecutor
    ) {
    }

    public function __invoke(ListTransferenciasQuery $query): CollectionContract
    {
        return $this->queryExecutor->execute($query);
    }
}
