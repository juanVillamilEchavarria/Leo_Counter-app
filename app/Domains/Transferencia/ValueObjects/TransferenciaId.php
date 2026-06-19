<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
namespace App\Domains\Transferencia\ValueObjects;

use App\Shared\Domain\Contracts\AggregateModelIdContract;
use App\Shared\Domain\ValueObjects\Abstracts\DomainId;

/**
 * Id de una transferencia
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 */
final readonly class TransferenciaId extends DomainId implements AggregateModelIdContract
{

}
