<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\MovimientoPendiente\Events;

use App\Domains\MovimientoPendiente\Aggregates\MovimientoPendiente;
use App\Shared\Domain\Contracts\CollectionContract;
use App\Shared\Domain\Contracts\EventContract;
use App\Shared\Domain\ValueObjects\Date;

final readonly class MovimientoPendienteWarningDayArrived implements EventContract
{
    /**
     * @param CollectionContract<MovimientoPendiente> $movimientosPendientes
     * @param Date $ocurredOn
     */
    public function __construct(
        private CollectionContract $movimientosPendientes,
        private Date $ocurredOn = new Date(new \DateTimeImmutable())
    )
    {
    }

    /**
     * @return CollectionContract
     */
    public function getMovimientosPendientes(): CollectionContract
    {
        return $this->movimientosPendientes;
    }

    /**
     * @inheritDoc
     */
    public function ocurredOn(): Date
    {
       return $this->ocurredOn;
    }
}
