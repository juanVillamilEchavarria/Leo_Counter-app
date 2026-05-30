<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Domains\MovimientoFijo\Events;

use App\Domains\MovimientoFijo\Aggregates\MovimientoFijo;
use App\Shared\Domain\Contracts\EventContract;
use App\Shared\Domain\ValueObjects\Date;

final readonly class MovimientoFijoWarningDayArrived implements EventContract
{
    public function __construct(
        private MovimientoFijo $movimientoFijo,
        private Date $ocurredOn
    )
    {
    }

    public function getMovimientoFijo(): MovimientoFijo
    {
        return $this->movimientoFijo;
    }
    /**
     * @inheritDoc
     */
    public function ocurredOn(): Date
    {
        return $this->ocurredOn;
    }
}
