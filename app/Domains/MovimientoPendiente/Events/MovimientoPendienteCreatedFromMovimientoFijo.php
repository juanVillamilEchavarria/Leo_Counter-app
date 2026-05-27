<?php

namespace App\Domains\MovimientoPendiente\Events;

use App\Shared\Domain\Contracts\EventContract;
use App\Shared\Domain\ValueObjects\Date;
use App\Domains\MovimientoPendiente\Aggregates\MovimientoPendiente;
use DateTimeImmutable;

/**
 * Evento de cuando se crea un movimiento pendiente a partir de un movimiento fijo.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\MovimientoPendiente\Events
 * @version 1.0.0
 * @since 1.0.0
 */
final readonly class MovimientoPendienteCreatedFromMovimientoFijo implements EventContract
{
    public function __construct(
        private MovimientoPendiente $movimientoPendiente,
        private Date $ocurredOn = new Date(new \DateTimeImmutable())
    )
    {
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
