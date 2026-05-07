<?php

namespace App\Shared\Domain\ValueObjects\Abstracts;

use App\Shared\Domain\Contracts\IdGeneratorContract;
use App\Shared\Domain\Contracts\AggregateModelIdContract;

/**
 * Value Object para el identificador de Dominio.
 * Implementa UUID v7 para garantizar secuencialidad en índices de base de datos.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Shared\Domain\ValueObjects\Abstracts
 * @since 1.0.0
 * @version 1.0.0
 */
abstract readonly class DomainId implements AggregateModelIdContract
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
     * Genera un nuevo CategoriaId con UUID v7 único.
     *
     * @return static Nueva instancia de CategoriaId
     */
    public static function generate(IdGeneratorContract $idGenerator): static
    {
        return new static($idGenerator->generate());
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
     * Compara si dos CategoriaId son iguales.
     *
     * @param self $other Otro CategoriaId para comparar
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
