<?php

namespace App\Application\Presupuesto\Commands\Handlers;

use App\Application\Presupuesto\Commands\UpdatePresupuestoCommand;
use App\Domains\Presupuesto\Contracts\Checkers\PresupuestoUniquenessCheckerContract;
use App\Domains\Presupuesto\Contracts\Repositories\PresupuestoRepositoryContract;
use App\Domains\Presupuesto\ValueObjects\PresupuestoId;

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
        private PresupuestoUniquenessCheckerContract $uniquenessChecker
    ) {}

    public function __invoke(UpdatePresupuestoCommand $command): bool
    {
        $aggregate = $this->repository->findById(new PresupuestoId($command->id));
        if (!$aggregate) {
            throw new \App\Domains\Presupuesto\Exceptions\CannotUpdatePresupuestoException(
                message: 'No se encontró el presupuesto para actualizar'
            );
        }

        $aggregate = $aggregate->updateData(
            categoria_id: $command->categoria_id,
            monto: $command->monto,
            descripcion: $command->descripcion,
            checker: $this->uniquenessChecker

        );

        return $this->repository->update($aggregate);
    }
}
