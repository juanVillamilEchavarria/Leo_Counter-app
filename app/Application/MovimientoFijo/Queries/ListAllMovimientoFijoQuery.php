<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\MovimientoFijo\Queries;

use App\Application\MovimientoFijo\Contracts\Queries\ListMovimientoFijoQueryContract;

/**
 * Query que representa la intencion de listar todos los movimientos fijos con sus detalles.
 * Es manejado por un query executor de infraestructura para obtener datos de lectura.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\MovimientoFijo\Queries
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class ListAllMovimientoFijoQuery implements ListMovimientoFijoQueryContract
{
}
