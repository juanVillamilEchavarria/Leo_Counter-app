<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Domains\Notificacion\ValueObjects;

use App\Shared\Domain\ValueObjects\Abstracts\DomainId;
use App\Shared\Domain\Contracts\AggregateModelIdContract;

/**
 * Value Object para el identificador del canal de notificación.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Notificacion\ValueObjects
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class CanalId extends DomainId implements AggregateModelIdContract
{
}
