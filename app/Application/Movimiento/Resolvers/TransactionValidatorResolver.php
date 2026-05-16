<?php

namespace App\Application\Movimiento\Resolvers;
use App\Domains\Cuenta\Aggregates\Cuenta;
use App\Domains\Movimiento\Aggregates\Movimiento;
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


    public function resolve(Cuenta $cuenta,Movimiento $movimiento) : bool{
        foreach($this->strategies as $strategy){
            if($strategy->supports($movimiento)){

                return $strategy->validate($cuenta, $movimiento);
            }
        }
        throw new \InvalidArgumentException("Tipo de movimiento no soportado");
    }
}
