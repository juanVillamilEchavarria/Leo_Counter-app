<?php

namespace App\Application\Presupuesto\Contracts\Queries;

use App\Shared\Application\Contracts\Queries\QueryContract;

/**
 * Contrato que deben implementar todos los queries de presupuestos que obtengan un listado de presupuestos.
 * Este contrato se pasar a los query executors para permitir consultas de diferentes filtros sin acoplar el executor contract a una clase de query específica.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
interface ListPresupuestosQueryContract extends QueryContract
{
}
