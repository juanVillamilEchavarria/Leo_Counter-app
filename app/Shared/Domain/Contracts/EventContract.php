<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Shared\Domain\Contracts;

use App\Shared\Domain\ValueObjects\Date;

/**
 * Contrato que deben implementar todos los eventos de dominio para que puedan ser reconocidos por el event Bus.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Shared\Domain\Contracts
 * @version 1.0.0
 */
interface EventContract
{
    /**
     * Retorna la fecha en la que ocurrio el evento
     * @return Date - la fecha en la que ocurrio el evento
     */
    public function ocurredOn(): Date;

}
