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
     * @param Movimiento $old_movimiento - el movimiento antes de ser modificado
     * @param Cuenta $old_cuenta - la cuenta asociada al movimiento antes de ser modifcado
     * @return Cuenta - la cuenta "vieja" con el efecto de la transaccion revertido
     * @throws \LogicException si no se encuentra una estrategia para revertir el efecto de la transaccion
     */
    public function resolve(Movimiento $old_movimiento, Cuenta $old_cuenta): Cuenta{
        foreach($this->strategies as $strategy){
            if($strategy->supports($old_movimiento)){
                return $strategy->revertTransactionEffectWhenAMovimientoChanges($old_movimiento, $old_cuenta);
            }
        }
        throw new \LogicException('No se encontro una estrategia para revertir el efecto de la transaccion');
    }

}
