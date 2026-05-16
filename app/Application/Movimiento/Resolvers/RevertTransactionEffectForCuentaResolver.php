<?php

namespace App\Application\Movimiento\Resolvers;
use App\Domains\Cuenta\Aggregates\Cuenta;
use App\Domains\Cuenta\ValueObjects\CuentaId;
use App\Domains\Movimiento\Aggregates\Movimiento;
use App\Domains\Movimiento\Contracts\Strategies\RevertTransactionEffectForCuentaStrategyContract;
use App\Domains\Movimiento\ValueObjects\RevertTransactionEffectForCuentaResultVO;
use App\Shared\Domain\ValueObjects\Amount;

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
     * @param Movimiento $movimiento - el movimiento modificado
     * @param Movimiento $old_movimiento - el movimiento antes de ser modificado
     * @param Cuenta $old_cuenta - la cuenta asociada al movimiento antes de ser modifcado
     * @return Cuenta - la cuenta "vieja" con el efecto de la transaccion revertido
     * @throws \LogicException si no se encuentra una estrategia para revertir el efecto de la transaccion
     */
    public function resolve(Movimiento $movimiento, Movimiento $old_movimiento, Cuenta $old_cuenta): Cuenta{
        foreach($this->strategies as $strategy){
            if($strategy->supports($movimiento)){
                return $strategy->revertTransactionEffectWhenAMovimientoChanges($old_movimiento, $old_cuenta);
            }
        }
        throw new \LogicException('No se encontro una estrategia para revertir el efecto de la transaccion');
    }

}
