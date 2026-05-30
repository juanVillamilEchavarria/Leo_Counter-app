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
 * Value Object de password, se encarga de validar la contraseña y hashearla antes de ser almacenada en la base de datos.
 */
final class Password
{
    public const MIN_LENGTH = 8;

    private function __construct(
        private string $password,
    ) {
    }

    /**
     * Crea una nueva contraseña desde texto plano, aplicando hashing.
     */
    public static function create(string $plainPassword): self
    {
        if(strlen($plainPassword)< self::MIN_LENGTH){
            throw new \InvalidArgumentException('La contraseña debe tener al menos 8 caracteres');
        }
        return new self(password_hash($plainPassword, PASSWORD_DEFAULT));
    }

    /**
     * Reconstituye una contraseña desde un hash ya existente (sin volver a hashear).
     */
    public static function fromHash(string $hashedPassword): self
    {
        return new self($hashedPassword);
    }

    public function __toString(): string
    {
        return $this->password;
    }
}
