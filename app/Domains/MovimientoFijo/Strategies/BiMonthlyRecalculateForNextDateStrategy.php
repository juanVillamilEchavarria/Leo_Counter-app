<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Domains\MovimientoFijo\Strategies;

use App\Domains\MovimientoFijo\Aggregates\MovimientoFijo;
use App\Domains\MovimientoFijo\Contracts\Strategies\RecalculateNextDateStrategyContract;
use App\Shared\Domain\ValueObjects\Date;
use App\Domains\MovimientoFijo\Enums\FrecuenciaMovimientoEnum;

/**
 * Estrategia para la recalculacion de la fecha proxima en un intervalo bimestral.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class BiMonthlyRecalculateForNextDateStrategy implements RecalculateNextDateStrategyContract
{

    /**
     * @inheritDoc
     */
    public function supports(MovimientoFijo $movimientoFijo): bool
    {
        return $movimientoFijo->getFrecuenciaMovimientoId() === FrecuenciaMovimientoEnum::BIMESTRAL;
    }

    /**
     * @inheritDoc
     */
    public function recalculateNextDate(MovimientoFijo $movimientoFijo): Date
    {
        $date = $movimientoFijo->getFechaProximo();
        return $date->addMonths('2');
    }
}
