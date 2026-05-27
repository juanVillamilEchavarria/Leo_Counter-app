<?php

namespace App\Domains\MovimientoFijo\Strategies;

use App\Domains\MovimientoFijo\Aggregates\MovimientoFijo;
use App\Domains\MovimientoFijo\Contracts\Strategies\RecalculateNextDateStrategyContract;
use App\Domains\MovimientoFijo\Enums\FrecuenciaMovimientoEnum;
use App\Shared\Domain\ValueObjects\Date;

/**
 * Estrategia para la recalculacion de la fecha proxima en un intervalo diario.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */

final readonly class DailyRecalculateForNextDateStrategy implements RecalculateNextDateStrategyContract
{
    public function supports(MovimientoFijo $movimientoFijo): bool
    {
        return $movimientoFijo->getFrecuenciaMovimientoId() === FrecuenciaMovimientoEnum::DIARIO;
    }

    /**
     * @inheritDoc
     */
    public function recalculateNextDate(MovimientoFijo $movimientoFijo): Date
    {
        $date = $movimientoFijo->getFechaProximo();
        return $date->addDays();
    }
}
