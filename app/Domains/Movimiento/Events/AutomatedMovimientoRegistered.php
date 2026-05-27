<?php

namespace App\Domains\Movimiento\Events;

use App\Domains\Cuenta\Aggregates\Cuenta;
use App\Domains\Movimiento\Aggregates\Movimiento;
use App\Domains\Movimiento\Contracts\Events\FinancialMovimientoRegisteredEventContract;
use App\Domains\Movimiento\Contracts\Events\MovimientoEventContract;
use App\Domains\MovimientoFijo\Aggregates\MovimientoFijo;
use App\Shared\Domain\ValueObjects\Date;

/**
 * Evento de cuando se registra un movimiento de forma automatica.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Movimiento\Events
 * @version 1.0.0
 * @since 1.0.0
 */
final readonly class AutomatedMovimientoRegistered implements FinancialMovimientoRegisteredEventContract, MovimientoEventContract
{

    public function __construct(
        private Movimiento $movimiento,
        private Cuenta $cuenta,
        private Date $ocurredOn = new Date(new \DateTimeImmutable())
    )
    {
    }

    /**
     * @inheritDoc
     */
    public function ocurredOn(): Date
    {
       return $this->ocurredOn;
    }

    public function getCuenta(): Cuenta
    {
        return $this->cuenta;
    }

    public function getMovimiento(): Movimiento
    {
        return $this->movimiento;
    }
}
