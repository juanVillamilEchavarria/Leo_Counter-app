<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Movimiento\Commands;
use App\Domains\MovimientoFijo\Aggregates\MovimientoFijo;
use App\Shared\Application\Contracts\Commands\TransactionalCommandContract;

/**
 * Comando que representa la intencion de registrar automaticamente un movimiento desde un movimiento fijo, este comando es utilizado en la automatizacion diaria de movimientos fijos
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class RegisterMovimientoFromMovimientoFijoCommand implements TransactionalCommandContract
{
    public function __construct(
        public MovimientoFijo $movimientoFijo
    )
    {
    }

}
