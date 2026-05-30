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
 * Value Object para representar un correo electrónico, valida su formato.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @version 1.0.0
 * @since 1.0.0
 */
final readonly class Email{
    private string $value;
    public function __construct(
         string $value
    )
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("El correo electrónico no es válido.");
        }
        $this->value = $value;
        
    }

    public function __toString(): string
    {
        return $this->value;
    }
}