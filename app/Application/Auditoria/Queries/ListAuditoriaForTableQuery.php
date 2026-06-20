<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Auditoria\Queries;

use App\Application\Auditoria\Contracts\Queries\ListAuditoriaQueryContract;
use App\Shared\Application\Queries\TableQuery;

/**
 * Query que representa la intención de obtener auditorías para una tabla (server side).
 * Sigue el patrón usado por ListMovimientoForTableQuery.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 */
final readonly class ListAuditoriaForTableQuery extends TableQuery implements ListAuditoriaQueryContract
{

}
