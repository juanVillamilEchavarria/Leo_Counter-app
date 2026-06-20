<?php
/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
namespace App\Domains\Auditoria\ValueObjects;

use App\Shared\Domain\Contracts\AggregateModelIdContract;
use App\Shared\Domain\ValueObjects\Abstracts\DomainId;

/**
 * Value object que representa el id del registro a auditar, por ejemplo el  id del registro de un movimiento o de un presupuesto
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 */
final readonly class AuditableRegisterId extends DomainId implements AggregateModelIdContract
{

}
