<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\MovimientoPendiente\Queries;

use App\Shared\Application\Contracts\Queries\QueryContract;

/**
 * Query que representa la intencion de contar los registros de MovimientoPendiente disponibles.
 * No transporta filtros porque el caso actual requiere el total de pendientes.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\MovimientoPendiente\Queries
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class GetMovimientoPendienteRecordsCountQuery implements QueryContract
{
}
