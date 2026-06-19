<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
namespace App\Application\Transferencia\Contracts\Queries\Executors;

use App\Shared\Domain\Contracts\CollectionContract;
use App\Application\Transferencia\Contracts\Queries\ListTransferenciaQueryContract;

/**
 * Contrato para el ejecutor de consulta de transferencias.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.1
 * @version 1.0.1
 */
interface TransferenciaQueryExecutorContract
{
    public function execute(ListTransferenciaQueryContract $query): CollectionContract;
}
