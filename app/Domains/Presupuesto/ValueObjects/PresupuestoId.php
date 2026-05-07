<?php

namespace App\Domains\Presupuesto\ValueObjects;
use App\Shared\Domain\Contracts\AggregateModelIdContract;
use App\Shared\Domain\ValueObjects\Abstracts\DomainId;
/**
 * Value Object para el identificador de presupuesto.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Presupuesto\ValueObjects
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class PresupuestoId extends DomainId implements AggregateModelIdContract {

}