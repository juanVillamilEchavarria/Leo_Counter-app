<?php

namespace App\Domains\Movimiento\ValueObjects;

use App\Shared\Domain\Contracts\AggregateModelIdContract;
use App\Shared\Domain\ValueObjects\Abstracts\DomainId;

/**
 * Value object que representa el id de un movimiento
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Movimiento\ValueObjects
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class MovimientoId extends DomainId implements AggregateModelIdContract
{

}
