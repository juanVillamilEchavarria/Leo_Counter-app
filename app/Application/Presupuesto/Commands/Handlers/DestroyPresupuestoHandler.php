<?php

namespace App\Application\Presupuesto\Commands\Handlers;

use App\Application\Presupuesto\Commands\DestroyPresupuestoCommand;
use App\Domains\Presupuesto\Contracts\Repositories\PresupuestoRepositoryContract;
use App\Domains\Presupuesto\ValueObjects\PresupuestoId;

final readonly class DestroyPresupuestoHandler
{
    public function __construct(
        private PresupuestoRepositoryContract $repository,
    ) {}

    public function __invoke(DestroyPresupuestoCommand $command): bool
    {
        return $this->repository->destroy(new PresupuestoId($command->id));
    }
}
