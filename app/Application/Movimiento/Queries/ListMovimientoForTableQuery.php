<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Movimiento\Queries;

use App\Application\Movimiento\Contracts\Queries\ListMovimientoQueryContract;
use App\Shared\Application\Queries\TableQuery;

/**
 * Query que representa la intención de obtener movimientos para ser mostrados en una tabla (server side).
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class ListMovimientoForTableQuery extends TableQuery implements ListMovimientoQueryContract
{

}
