<?php

namespace App\Domains\MovimientoFijo\Events;

use App\Shared\Domain\Contracts\EventContract;
use App\Shared\Domain\ValueObjects\Date;
use App\Domains\MovimientoFijo\Aggregates\MovimientoFijo;
use App\Domains\MovimientoPendiente\Aggregates\MovimientoPendiente;

/**
 * Evento que ocurre cuando un movimiento fijo crea un movimiento pendiente a partir de este.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\MovimientoFijo\Events
 * @version 1.0.0
 * @since 1.0.0
 */
final readonly class MovimientoFijoCreatedAMovimientoPendiente implements EventContract
{
    public function __construct(
        private MovimientoFijo $movimientoFijo,
        private MovimientoPendiente $movimientoPendiente,
        private Date $ocurredOn = new Date(new \DateTimeImmutable())
    )
    {
    }

    public function getMovimientoFijo(): MovimientoFijo
    {
        return $this->movimientoFijo;
    }

    public function getMovimientoPendiente(): MovimientoPendiente
    {
        return $this->movimientoPendiente;
    }

    /**
     * @inheritDoc
     */
    public function ocurredOn(): Date
    {
       return $this->ocurredOn;
    }
}
