<?php

namespace App\Domains\Cuenta\ValueObjects;

use App\Shared\Domain\Contracts\IdGeneratorContract;
use App\Shared\Domain\Contracts\AggregateModelIdContract;

/**
 * Value Object para el identificador de cuenta.
 * Implementa UUID v7 para garantizar secuencialidad en índices de base de datos.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Cuenta\ValueObjects
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class CuentaId implements AggregateModelIdContract
{
    /**
     * Constructor con el valor UUID como string.
     *
     * @param string $id UUID en formato string
     */
    public function __construct(
        private string $id
    ) {
    }

    /**
     * Genera un nuevo CuentaId con UUID v7 único.
     *
     * @return self Nueva instancia de CuentaId
     */
    public static function generate(): self
    {
        return new self(IdGeneratorContract::generate());
    }

    /**
     * Retorna el valor del UUID como string.
     *
     * @return string UUID en formato string
     */
    public function getValue(): string
    {
        return $this->id;
    }

    /**
     * Compara si dos CuentaId son iguales.
     *
     * @param self $other Otro CuentaId para comparar
     * @return bool true si los values son iguales
     */
    public function equals(self $other): bool
    {
        return $this->id === $other->id;
    }

    /**
     * Devuelve el UUID como string.
     *
     * @return string Representación string del UUID
     */
    public function __toString(): string
    {
        return $this->id;
    }
}
