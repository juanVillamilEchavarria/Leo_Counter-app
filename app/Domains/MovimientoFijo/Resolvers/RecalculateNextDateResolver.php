<?php

namespace App\Domains\MovimientoFijo\Resolvers;
use App\Domains\MovimientoFijo\Aggregates\MovimientoFijo;
use App\Domains\MovimientoFijo\Contracts\Strategies\RecalculateNextDateStrategyContract;
use App\Shared\Domain\ValueObjects\Date;

/**
 * Resuelve la estrategia para la recalculacion de la fecha proxima.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class RecalculateNextDateResolver
{
    /**
     *@param iterable<RecalculateNextDateStrategyContract> $strategies
     */
    public function __construct(
        private  iterable $strategies
    )
    {
    }
    public function resolve(MovimientoFijo $movimientoFijo): Date{
        foreach ($this->strategies as $strategy){
            if($strategy->supports($movimientoFijo)){
                return $strategy->recalculateNextDate($movimientoFijo);
            }
        }
        throw new \LogicException('No se encontro una estrategia para la recalculacion de la fecha proxima');
    }

}
