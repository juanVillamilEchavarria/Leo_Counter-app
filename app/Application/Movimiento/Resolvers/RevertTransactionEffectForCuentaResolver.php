<?php

namespace App\Application\Movimiento\Resolvers;
use App\Application\Movimiento\Contracts\Commands\ModifyMovimientoCommandContract;
use App\Domains\Cuenta\Aggregates\Cuenta;
use App\Domains\Movimiento\Aggregates\Movimiento;
use App\Domains\Movimiento\Contracts\Strategies\RevertTransactionEffectForCuentaStrategyContract;
final readonly class RevertTransactionEffectForCuentaResolver
{
    /**
     * @param iterable<RevertTransactionEffectForCuentaStrategyContract> $strategies
     */
    public function __construct(
        private iterable $strategies
    )
    {
    }

    /**
     * @param ModifyMovimientoCommandContract $command
     * @param Movimiento $movimiento - el movimiento ANTES de ser modificado
     * @param Cuenta $cuenta - la cuenta asociada al comando (o al movimiento si son iguales)
     * @return Cuenta - la cuenta con la transaccion revertida
     * @throws \LogicException si no se encuentra una estrategia para revertir el efecto de la transaccion
     */
    public function resolve(ModifyMovimientoCommandContract $command, Movimiento $movimiento, Cuenta $cuenta): Cuenta{
        foreach($this->strategies as $strategy){
            if($strategy->supports($command,$movimiento)){
                return $strategy->revertTransactionEffectWhenAMovimientoChanges($command,$movimiento, $cuenta);
            }
        }
        throw new \LogicException('No se encontro una estrategia para revertir el efecto de la transaccion');
    }

}
