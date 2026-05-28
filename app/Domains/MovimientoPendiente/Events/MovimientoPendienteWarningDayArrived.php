<?php

namespace App\Domains\MovimientoPendiente\Events;

use App\Domains\MovimientoPendiente\Aggregates\MovimientoPendiente;
use App\Shared\Domain\Contracts\EventContract;
use App\Shared\Domain\ValueObjects\Date;

final readonly class MovimientoPendienteWarningDayArrived implements EventContract
{
    public function __construct(
        private MovimientoPendiente $movimientoPendiente,
        private Date $ocurredOn = new Date(new \DateTimeImmutable())
    )
    {
    }

    /**
     * @return MovimientoPendiente
     */
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
