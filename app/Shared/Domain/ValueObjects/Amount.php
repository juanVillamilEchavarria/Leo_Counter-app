<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Shared\Domain\ValueObjects;


/**
 * Valor monetario de un movimiento
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class Amount
{
    private float $amount;
    public function __construct(
         float $amount
    ) {
        if($amount<0){
            throw new \InvalidArgumentException('El monto debe ser positivo');
        }
        $this->amount = $amount;
    }

    public function getValue(): float{
        return $this->amount;
    }



}
