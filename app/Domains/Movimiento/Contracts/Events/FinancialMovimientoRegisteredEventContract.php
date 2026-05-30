<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Domains\Movimiento\Contracts\Events;

use App\Domains\Cuenta\Aggregates\Cuenta;
use App\Domains\Movimiento\Aggregates\Movimiento;
use App\Shared\Domain\Contracts\EventContract;

/**
 * Contrato que deben implementar todos los eventos que financieros de movimientos registrados (aplica solo para el caso de creacion de movimientos).
 * se utiliza cuando el movimeinto es creado manualmente o automaticamente.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *  @package App\Domains\Movimiento\Contracts\Events
 *  @version 1.0.0
 *  @since 1.0.0
 */
interface FinancialMovimientoRegisteredEventContract extends EventContract
{
    public function getMovimiento(): Movimiento;

}
