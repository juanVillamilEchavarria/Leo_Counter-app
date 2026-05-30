<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Movimiento\Contracts\Queries;

use App\Shared\Application\Contracts\Queries\QueryContract;

/**
 * Contrato que deben implementar todos los queries de movimientos que obtengan un listado de movimientos.
 * Este contrato se pasa a los query executors para permitir consultas de diferentes filtros sin acoplar el executor contract a una clase de query específica.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
interface ListMovimientoQueryContract extends QueryContract
{
}
