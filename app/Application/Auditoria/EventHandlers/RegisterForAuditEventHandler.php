<?php
/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
namespace App\Application\Auditoria\EventHandlers;
use App\Domains\Auditoria\Aggregates\Auditoria;
use App\Domains\Auditoria\Contracts\Repositories\AuditoriaRepositoryContract;
use App\Domains\Auditoria\ValueObjects\AuditableRegisterId;
use App\Domains\Auditoria\ValueObjects\AuditoriaId;
use App\Shared\Application\Contracts\Services\AuthServiceContract;
use App\Shared\Application\Events\AuditableActionOcurred;
use App\Shared\Application\Exceptions\CannotAuditRegisterException;
use App\Shared\Domain\Contracts\IdGeneratorContract;
use App\Shared\Domain\ValueObjects\JsonPayload;

/**
 * Manejador de eventos para un registro que necesita ser auditado
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
final readonly class RegisterForAuditEventHandler
{
    public function __construct(
        private AuditoriaRepositoryContract $auditoriaRepository,
        private AuthServiceContract $authService,
        private IdGeneratorContract $idGenerator
    )
    {
    }

    public function __invoke(AuditableActionOcurred $event ) : void
    {
        $user = $this->authService->getAuthenticatedUser();
        if(!$user)return;

        $primitiveOldAggregate = $event->getOldAggregate()?->toPrimitive() ?? null;
        $primitiveNewAggregate= $event->getNewAggregate()?->toPrimitive() ?? null;

        $targetAggregate = $event->getNewAggregate() ?? $event->getOldAggregate();

        if($targetAggregate === null) throw new CannotAuditRegisterException('No se puede auditar un registro sin un id') ;
        $auditoria= Auditoria::create(
            id: AuditoriaId::generate($this->idGenerator),
            user_id: $user->getId(),
            auditable_type: $event->getType(),
            auditable_id: new AuditableRegisterId($targetAggregate->getId()->getValue()),
            action: $event->getAction(),
            old_values: $primitiveOldAggregate !== null ? new JsonPayload($primitiveOldAggregate) : null,
            new_values: $primitiveNewAggregate !== null ? new JsonPayload($primitiveNewAggregate) : null
        );
        $this->auditoriaRepository->store($auditoria);
    }

}
