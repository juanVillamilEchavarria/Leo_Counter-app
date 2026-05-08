<?php

namespace App\Domains\Propietario\ValueObjects;

use App\Shared\Domain\Contracts\AggregateModelIdContract;
use App\Shared\Domain\ValueObjects\Abstracts\DomainId;

/**
 * Value Object para el identificador de propietario.
 * Implementa UUID v7 para garantizar secuencialidad en índices de base de datos.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Propietario\ValueObjects
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class PropietarioId extends DomainId implements AggregateModelIdContract
{
}
