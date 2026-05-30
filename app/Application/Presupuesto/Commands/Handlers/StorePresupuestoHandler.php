<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Presupuesto\Commands\Handlers;

use App\Application\Presupuesto\Commands\StorePresupuestoCommand;
use App\Domains\Presupuesto\Aggregates\Presupuesto as PresupuestoAggregate;
use App\Domains\Presupuesto\Contracts\Checkers\PresupuestoUniquenessCheckerContract;
use App\Domains\Presupuesto\Contracts\Repositories\PresupuestoRepositoryContract;
use App\Domains\Presupuesto\ValueObjects\PresupuestoId;
use App\Domains\Categoria\ValueObjects\CategoriaId;
use App\Shared\Domain\Contracts\IdGeneratorContract;
use App\Shared\Domain\ValueObjects\Date;
use DateTimeImmutable;

final readonly class StorePresupuestoHandler
{
    public function __construct(
        private PresupuestoRepositoryContract $repository,
        private PresupuestoUniquenessCheckerContract $uniquenessChecker,
        private IdGeneratorContract $idGenerator
    ) {}


    public function __invoke(StorePresupuestoCommand $command)
    {
        $presupuesto = PresupuestoAggregate::create(
            id: PresupuestoId::generate($this->idGenerator),
            categoria_id: new CategoriaId($command->categoria_id),
            monto: $command->monto,
            periodo: new Date(new DateTimeImmutable()),
            descripcion: $command->descripcion,
            user_id: $command->user_id,
            checker: $this->uniquenessChecker
        );

        return $this->repository->store($presupuesto);
    }
}
