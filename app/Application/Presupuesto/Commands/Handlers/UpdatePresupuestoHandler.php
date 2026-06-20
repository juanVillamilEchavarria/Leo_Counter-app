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

use App\Application\Presupuesto\Commands\UpdatePresupuestoCommand;
use App\Domains\Presupuesto\Contracts\Checkers\PresupuestoUniquenessCheckerContract;
use App\Domains\Presupuesto\Contracts\Repositories\PresupuestoRepositoryContract;
use App\Domains\Presupuesto\ValueObjects\PresupuestoId;
use App\Domains\Categoria\ValueObjects\CategoriaId;
use App\Shared\Domain\ValueObjects\Amount;
use App\Shared\Application\Contracts\Bus\EventBus;
use App\Shared\Application\Events\AuditableActionOcurred;
use App\Domains\Auditoria\Enums\AuditableActions;
use App\Domains\Auditoria\Enums\AuditableTypes;

/**
 * Handler que se encarga de actualizar un presupuesto.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Presupuesto\Commands\Handlers
 * @version 1.0.0
 * @since 1.0.0
 */
final readonly class UpdatePresupuestoHandler
{
    public function __construct(
        private PresupuestoRepositoryContract $repository,
        private PresupuestoUniquenessCheckerContract $uniquenessChecker,
        private EventBus $eventBus
    ) {}

    public function __invoke(UpdatePresupuestoCommand $command): bool
    {
        $aggregate = $this->repository->findById(new PresupuestoId($command->id));
        if (!$aggregate) {
            throw new \App\Domains\Presupuesto\Exceptions\CannotUpdatePresupuestoException(
                message: 'No se encontró el presupuesto para actualizar'
            );
        }

        $oldAggregate = $aggregate;

        $aggregate = $aggregate->updateData(
            categoria_id: new CategoriaId($command->categoria_id),
            monto: new Amount((float) $command->monto),
            descripcion: $command->descripcion,
            checker: $this->uniquenessChecker

        );

        $success = $this->repository->update($aggregate);

        if ($success) {
            $this->eventBus->publish(new AuditableActionOcurred(
                old_aggregate: $oldAggregate,
                new_aggregate: $aggregate,
                action: AuditableActions::UPDATE,
                type: AuditableTypes::PRESUPUESTOS
            ));
        }

        return $success;
    }
}
