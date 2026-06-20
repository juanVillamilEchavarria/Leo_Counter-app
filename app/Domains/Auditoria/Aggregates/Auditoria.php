<?php
/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
namespace App\Domains\Auditoria\Aggregates;

use App\Shared\Domain\Contracts\AggregateModelContract;
use App\Shared\Domain\Contracts\AggregateModelIdContract;
use App\Domains\Auditoria\ValueObjects\AuditoriaId;
use App\Domains\Usuario\ValueObjects\UsuarioId;
use App\Domains\Auditoria\Enums\AuditableTypes;
use App\Domains\Auditoria\ValueObjects\AuditableRegisterId;
use App\Domains\Auditoria\Enums\AuditableActions;
use App\Shared\Domain\ValueObjects\JsonPayload;

final readonly class Auditoria implements AggregateModelContract
{
    public function __construct(
        private AuditoriaId $id,
        private UsuarioId $user_id,
        private AuditableTypes $auditable_type,
        private AuditableRegisterId $auditable_id,
        private AuditableActions $action,
        private ?JsonPayload $old_values,
        private ?JsonPayload $new_values
    )
    {
    }

    /**
     * Crea una nueva instancia de Auditoria.
     */
    public static function create (
         AuditoriaId $id,
         UsuarioId $user_id,
         AuditableTypes $auditable_type,
         AuditableRegisterId $auditable_id,
         AuditableActions $action,
         ?JsonPayload $old_values,
         ?JsonPayload $new_values
    ) : self{
        return new self(
            id: $id,
            user_id: $user_id,
            auditable_type: $auditable_type,
            auditable_id: $auditable_id,
            action: $action,
            old_values: $old_values,
            new_values: $new_values
        );

    }
    /**
     * Reconstituye una instancia de Auditoria existente.
     */
        public static function reconstitute (
         AuditoriaId $id,
         UsuarioId $user_id,
         AuditableTypes $auditable_type,
         AuditableRegisterId $auditable_id,
         AuditableActions $action,
         ?JsonPayload $old_values,
         ?JsonPayload $new_values
    ): self{
        return new self(
            id: $id,
            user_id: $user_id,
            auditable_type: $auditable_type,
            auditable_id: $auditable_id,
            action: $action,
            old_values: $old_values,
            new_values: $new_values
        );

    }

    public function getId(): AggregateModelIdContract
    {
       return $this->id;
    }

    public function getUserId(): UsuarioId
    {
        return $this->user_id;
    }
    public function getAuditableType(): AuditableTypes
    {
        return $this->auditable_type;
    }
    public function getAuditableId(): AuditableRegisterId
    {
        return $this->auditable_id;
    }
    public function getAction(): AuditableActions
    {
        return $this->action;
    }
    public function getOldValues(): ?JsonPayload
    {
        return $this->old_values;
    }
    public function getNewValues(): ?JsonPayload
    {
        return $this->new_values;
    }
}
