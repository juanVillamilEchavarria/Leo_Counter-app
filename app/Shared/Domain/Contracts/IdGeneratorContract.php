<?php

namespace App\Shared\Domain\Contracts;

/**
 * Contrato que define la interfaz para la generacion de identificadores unicos.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Shared\Domain\Contracts
 * @since 1.0.0
 * @version 1.0.0
 */
interface IdGeneratorContract
{
    /**
     * Genera un identificador unico, debe ser un UUID V7.
     * @return string
     */
    public  function generate(): string;
}