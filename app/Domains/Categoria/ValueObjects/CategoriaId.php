<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Domains\Categoria\ValueObjects;
use App\Shared\Domain\ValueObjects\Abstracts\DomainId;
use App\Shared\Domain\Contracts\IdGeneratorContract;
use App\Shared\Domain\Contracts\AggregateModelIdContract;

/**
 * Value Object para el identificador de categoría.
 * Implementa UUID v7 para garantizar secuencialidad en índices de base de datos.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Categoria\ValueObjects
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class CategoriaId extends DomainId implements AggregateModelIdContract
{
}
