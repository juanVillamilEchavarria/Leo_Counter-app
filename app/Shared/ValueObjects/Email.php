<?php

namespace App\Shared\ValueObjects;

/**
 * Value Object para representar un correo electrónico, valida su formato.
 */
final class Email{
    public function __construct(
        public string $value
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