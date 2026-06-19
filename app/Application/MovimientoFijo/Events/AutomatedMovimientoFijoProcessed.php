<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\MovimientoFijo\Events;

use App\Shared\Domain\Contracts\CollectionContract;
use App\Shared\Domain\Contracts\EventContract;
use App\Shared\Domain\ValueObjects\Date;
use App\Domains\MovimientoFijo\Aggregates\MovimientoFijo;

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
