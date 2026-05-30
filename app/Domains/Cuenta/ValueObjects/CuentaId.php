<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Domains\Cuenta\ValueObjects;

use App\Shared\Domain\Contracts\IdGeneratorContract;
use App\Shared\Domain\Contracts\AggregateModelIdContract;
use App\Shared\Domain\ValueObjects\Abstracts\DomainId;

/**
 * Value Object para el identificador de cuenta.
 * Implementa UUID v7 para garantizar secuencialidad en índices de base de datos.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Cuenta\ValueObjects
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class CuentaId extends DomainId implements AggregateModelIdContract
{
}
