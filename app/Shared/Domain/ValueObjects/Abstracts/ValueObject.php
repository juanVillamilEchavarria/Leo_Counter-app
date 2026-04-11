<?php

namespace App\Shared\Domain\ValueObjects;

/**
 * Clase base para todos los Value Objects del dominio.
 * Los VOs son inmutables por definición — nunca se modifican, se reemplazan.
 * No tienen identidad propia — su igualdad se determina por sus atributos.
 * Zero dependencias de framework — dominio puro.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Shared\Domain\ValueObjects
 * @since 1.0.0
 */
abstract class ValueObject
{
    /**
     * Compara dos VOs por valor — no por referencia.
     * Dos VOs son iguales si todos sus atributos son iguales.
     */
    public function equals(self $other): bool
    {
        return $this == $other;
    }

    /**
     * Garantiza que los VOs no puedan ser clonados directamente.
     * Para "modificar" un VO, se debe crear una nueva instancia.
     */
    final public function with(array $overrides): static
    {
        $current = get_object_vars($this);
        $merged  = array_merge($current, $overrides);
        return new static(...array_values($merged));
    }
}