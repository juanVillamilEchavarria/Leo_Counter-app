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
