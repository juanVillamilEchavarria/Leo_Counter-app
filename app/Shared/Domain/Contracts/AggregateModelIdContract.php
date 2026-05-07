<?php

namespace App\Shared\Domain\Contracts;

/**
 * Contrato que representa el identificador de un modelo de agregado de dominio.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Shared\Domain\Contracts
 * @since 1.0.0
 * @version 1.0.0
 */
interface AggregateModelIdContract{
    /**
     * Devuelve el identificador.
     * @return string
     */
    public function getValue(): string;
}