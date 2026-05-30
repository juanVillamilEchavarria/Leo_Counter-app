<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Movimiento\Resolvers;

use App\Domains\Cuenta\Aggregates\Cuenta;
use App\Domains\Movimiento\Aggregates\Movimiento;
use App\Domains\Movimiento\Contracts\Strategies\ApplyTransactionEffectForCuentaStrategyContract;
class ApplyTransactionEffectForCuentaResolver
{

    /**
     * @param iterable<ApplyTransactionEffectForCuentaStrategyContract> $strategies
     */
    public function __construct(
        private iterable $strategies
    )
    {
    }

    public function resolve(Movimiento $movimiento, Cuenta $cuenta):Cuenta{
        foreach ($this->strategies as $strategy){
            if($strategy->supports($movimiento)){
                return $strategy->applyTransactionEffectWhenAMovimientoIsWritten($movimiento, $cuenta);
            }
        }
        throw new \LogicException('No se encontro una estrategia para aplicar el efecto de la transaccion');
    }
}
