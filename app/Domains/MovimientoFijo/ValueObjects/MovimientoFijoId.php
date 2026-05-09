<?php

namespace App\Domains\MovimientoFijo\ValueObjects;

use App\Shared\Domain\Contracts\AggregateModelIdContract;
use App\Shared\Domain\ValueObjects\Abstracts\DomainId;

/**
 * Value Object para la identidad del agregado MovimientoFijo.
 * Encapsula el UUID v7 que identifica de forma unica un movimiento fijo dentro del dominio.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\MovimientoFijo\ValueObjects
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class MovimientoFijoId extends DomainId implements AggregateModelIdContract
{
}
