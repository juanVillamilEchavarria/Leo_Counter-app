<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
namespace App\Application\Transferencia\Queries;

use App\Application\Transferencia\Contracts\Queries\ListTransferenciaQueryContract;
use App\Shared\Application\Queries\TableQuery;

/**
 * Query para listar transferencias para ser mostradas en una tabla (server side).
 * Implementa el contrato marcador del módulo Transferencia y extiende TableQuery para filtros/paginación.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.1
 * @version 1.0.1
 */
final readonly class ListTransferenciasForTableQuery extends TableQuery implements ListTransferenciaQueryContract
{

}
