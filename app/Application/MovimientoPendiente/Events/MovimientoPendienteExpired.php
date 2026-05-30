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
use App\Shared\Domain\Contracts\EventContract;
use App\Shared\Domain\ValueObjects\Date;

/**
 * Evento que ocurre cuando un movimiento pendiente se vence.
 * @package App\Domains\MovimientoPendiente\Events
 * @since 1.0.0
 * @version 1.0.0
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 */
final readonly class MovimientoPendienteExpired implements EventContract
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
