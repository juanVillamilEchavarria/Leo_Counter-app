<?php
/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
namespace App\Shared\Application\Events;

use App\Domains\Auditoria\Enums\AuditableActions;
use App\Shared\Domain\Contracts\EventContract;
use App\Shared\Domain\ValueObjects\Date;
use App\Shared\Domain\Contracts\PrimitiveAggregateModelContract;
use App\Domains\Auditoria\Enums\AuditableTypes;
/**
 * Evento que ocurre cuando se crea un nuevo registro que necesita ser auditado
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 */
final readonly class AuditableActionOcurred implements EventContract
{
    public function __construct(
        private ?PrimitiveAggregateModelContract $old_aggregate,
        private ?PrimitiveAggregateModelContract $new_aggregate,
        private AuditableActions $action,
        private AuditableTypes $type,
        private Date $ocurredOn = new Date(new \DateTimeImmutable())
    )
    {
    }

    /**
     * @return AuditableActions
     */
    public function getAction(): AuditableActions
    {
        return $this->action;
    }

    /**
     * @return AuditableTypes
     */
    public function getType(): AuditableTypes
    {
        return $this->type;
    }

    public function getOldAggregate(): ?PrimitiveAggregateModelContract
    {
        return $this->old_aggregate;
    }

    /**
     * @return PrimitiveAggregateModelContract
     */
    public function getNewAggregate(): ?PrimitiveAggregateModelContract
    {
        return $this->new_aggregate;
    }

    /**
     * @inheritDoc
     */
    public function ocurredOn(): Date
    {
        return $this->ocurredOn;
    }
}
