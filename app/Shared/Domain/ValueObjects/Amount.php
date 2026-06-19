<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.1
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
    private int $cents;

    public function __construct(float $amount)
    {
        if ($amount < 0) {
            throw new \InvalidArgumentException('El monto debe ser positivo');
        }
        $this->cents = (int) round($amount * 100);
    }

    public function getValue(): float
    {
        return $this->cents / 100;
    }

    /**
     * Suma un monto con otro monto
     * @param Amount $other
     * @return self
     */
    public function add(Amount $other): self
    {
        return new self(($this->cents + $other->cents) / 100);
    }

    /**
     * Resta el monto con otro monto
     * @param Amount $other
     * @return self
     */
    public function subtract(Amount $other): self
    {
        $result = $this->cents - $other->cents;
        if ($result < 0) {
            throw new \InvalidArgumentException('El resultado no puede ser negativo');
        }
        return new
         self($result / 100);
    }


    public function isLessOrEqualThanCero(): bool
    {
        return $this->cents <= 0;
    }
}
