<?php

namespace App\Application\Movimiento\Resolvers;
use App\Domains\Cuenta\Aggregates\Cuenta;
use App\Domains\Movimiento\Contracts\Strategies\TransactionValidatorStrategyContract;

final readonly class TransactionValidatorResolver{

    /**
     * @param TransactionValidatorStrategyContract[] $strategies
     */
    public function __construct(
      private iterable $strategies
    )
    {
    }


    public function resolve(Cuenta $cuenta, float $monto, int $tipo_movimiento_id) : bool{
        foreach($this->strategies as $strategy){
            if($strategy->supports($tipo_movimiento_id)){

                return $strategy->resolve($cuenta, $monto);
            }
        }
        throw new \InvalidArgumentException("Tipo de movimiento no soportado");
    }
}
