<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.1
 */
namespace App\Application\Presupuesto\Commands\Handlers;

use App\Application\Presupuesto\Commands\DestroyPresupuestoCommand;
use App\Domains\Presupuesto\Contracts\Repositories\PresupuestoRepositoryContract;
use App\Domains\Presupuesto\ValueObjects\PresupuestoId;
use App\Shared\Application\Contracts\Bus\EventBus;
use App\Shared\Application\Events\AuditableActionOcurred;
use App\Domains\Auditoria\Enums\AuditableActions;
use App\Domains\Auditoria\Enums\AuditableTypes;

final readonly class DestroyPresupuestoHandler
{
    public function __construct(
        private PresupuestoRepositoryContract $repository,
        private EventBus $eventBus
    ) {}

    public function __invoke(DestroyPresupuestoCommand $command): bool
    {
        $presupuesto = $this->repository->findById(new PresupuestoId($command->id));

        $success = $this->repository->destroy(new PresupuestoId($command->id));

        if ($success) {
            $this->eventBus->publish(new AuditableActionOcurred(
                old_aggregate: $presupuesto,
                new_aggregate: null,
                type: AuditableTypes::PRESUPUESTOS,
                action: AuditableActions::DELETE
            ));
        }

        return $success;
    }
}
