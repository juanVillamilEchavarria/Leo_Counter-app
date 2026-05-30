<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Domains\MovimientoFijo\Contracts\Strategies;
use App\Domains\MovimientoFijo\Aggregates\MovimientoFijo;
use App\Shared\Domain\ValueObjects\Date;

/**
 * Contrato para las estrategias de recalculacion de la fecha del proximo registro para el movimiento fijo.
 * Se hace un contrato ya que hay varias frecuencias de movimeinto, cada frecuencia debe implementar una clase que implemente esta interfaz.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\MovimientoFijo\Contracts\Strategies
 * @since 1.0.0
 * @version 1.0.0
 */
interface RecalculateNextDateStrategyContract
{
    /**
     * Indica si la estrategia es compatible con el movimiento fijo
     * @param MovimientoFijo $movimientoFijo
     * @return bool
     */
    public function supports(MovimientoFijo $movimientoFijo): bool;
    /**
     * Devuelve la fecha del proximo registro recalculada para el movimiento fijo
     * @param MovimientoFijo $movimientoFijo
     * @return Date
     */
    public function recalculateNextDate(MovimientoFijo $movimientoFijo): Date;

}
