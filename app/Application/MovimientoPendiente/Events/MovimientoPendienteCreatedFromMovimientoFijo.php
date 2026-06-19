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

use App\Domains\MovimientoFijo\Aggregates\MovimientoFijo;
use App\Shared\Domain\Contracts\CollectionContract;
use App\Shared\Domain\Contracts\EventContract;
use App\Shared\Domain\ValueObjects\Date;

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
    /**
     * @param CollectionContract<MovimientoFijo> $movimientosFijos
     * @param Date $ocurredOn
     */
    public function __construct(
        private CollectionContract $movimientosFijos,
        private Date $ocurredOn = new Date(new \DateTimeImmutable())
    )
    {
    }

    public function getMovimientosFijos(): CollectionContract
    {
        return $this->movimientosFijos;
    }

    /**
     * @inheritDoc
     */
    public function ocurredOn(): Date
    {
        return $this->ocurredOn;
    }
}
