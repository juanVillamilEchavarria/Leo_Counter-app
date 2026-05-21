<?php

namespace App\Domains\Usuario\ValueObjects;

use App\Shared\Domain\Contracts\AggregateModelIdContract;
use App\Shared\Domain\ValueObjects\Abstracts\DomainId;

/**
 * Value Object para el identificador del usuario.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Usuario\ValueObjects
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class UsuarioId extends DomainId implements AggregateModelIdContract
{
}
