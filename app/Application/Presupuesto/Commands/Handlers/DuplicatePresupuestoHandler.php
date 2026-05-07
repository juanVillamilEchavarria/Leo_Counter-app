<?php

namespace App\Application\Presupuesto\Commands\Handlers;

use App\Application\Presupuesto\Commands\DuplicatePresupuestoCommand;
use App\Domains\Presupuesto\Aggregates\Presupuesto as PresupuestoAggregate;
use App\Domains\Presupuesto\Contracts\Checkers\PresupuestoCanDuplicateCheckerContract;
use App\Domains\Presupuesto\Contracts\Checkers\PresupuestoUniquenessCheckerContract;
use App\Domains\Presupuesto\Contracts\Repositories\PresupuestoRepositoryContract;
use App\Domains\Presupuesto\ValueObjects\PresupuestoId;
use App\Shared\Domain\Contracts\IdGeneratorContract;

final readonly class DuplicatePresupuestoHandler
{
    public function __construct(
        private PresupuestoRepositoryContract $repository,
        private PresupuestoCanDuplicateCheckerContract $duplicateChecker,
        private IdGeneratorContract $idGenerator
    ) {}

    public function __invoke(DuplicatePresupuestoCommand $command)
    {
        /**
         * @var PresupuestoAggregate
         */
        $aggregate = $this->repository->findById(new PresupuestoId($command->id));

        if (!$aggregate) {
            throw new \App\Domains\Presupuesto\Exceptions\CannotStorePresupuestoException(
                message: 'No se encontró el presupuesto a duplicar'
            );
        }
        $id = PresupuestoId::generate($this->idGenerator);
        $duplicate = $aggregate->duplicate($id, $this->duplicateChecker);


        return $this->repository->store($duplicate);
    }
}
