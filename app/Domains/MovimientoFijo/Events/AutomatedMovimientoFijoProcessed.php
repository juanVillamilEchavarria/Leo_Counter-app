<?php

namespace App\Domains\MovimientoFijo\Events;

use App\Domains\MovimientoFijo\Aggregates\MovimientoFijo;
use App\Shared\Domain\Contracts\EventContract;
use App\Shared\Domain\ValueObjects\Date;
use App\Domains\Movimiento\Aggregates\Movimiento;

/**
 * Evento que ocurre cuando un movimiento fijo es procesado y se crea un movimiento a partir de este.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\MovimientoFijo\Events
 * @version 1.0.0
 * @since 1.0.0
 */
final readonly class AutomatedMovimientoFijoProcessed implements EventContract
{
    public function __construct(
        private MovimientoFijo $movimientoFijo,
        private Movimiento $movimiento,
        private Date $ocurredOn = new Date(new \DateTimeImmutable())
    )
    {
    }

    public function getMovimientoFijo(): MovimientoFijo
    {
        return $this->movimientoFijo;
    }

    public function getMovimiento(): Movimiento
    {
        return $this->movimiento;
    }

    /**
     * @inheritDoc
     */
    public function ocurredOn(): Date
    {
        return $this->ocurredOn;
    }
}
