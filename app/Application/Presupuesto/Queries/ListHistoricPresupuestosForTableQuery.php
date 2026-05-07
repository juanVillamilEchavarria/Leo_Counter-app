<?php

namespace App\Application\Presupuesto\Queries;

use App\Application\Presupuesto\Contracts\Queries\ListPresupuestosQueryContract;
use App\Shared\Application\Queries\TableQuery;
/**
 * Query que representa la intencion de obtener los presupuestos historicos para ser mostrados en una tabla (server side).
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class ListHistoricPresupuestosForTableQuery extends TableQuery implements ListPresupuestosQueryContract
{

}
