<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Domains\MovimientoPendiente\ValueObjects;

use App\Shared\Domain\Contracts\AggregateModelIdContract;
use App\Shared\Domain\ValueObjects\Abstracts\DomainId;

/**
 * Clase que representa el id de un movimiento pendiente
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 * @package App\Domains\MovimientoPendiente\ValueObjects
 */
final readonly class MovimientoPendienteId extends DomainId implements AggregateModelIdContract
{

}
