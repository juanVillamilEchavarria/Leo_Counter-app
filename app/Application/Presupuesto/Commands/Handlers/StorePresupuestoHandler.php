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

use App\Application\Presupuesto\Commands\StorePresupuestoCommand;
use App\Domains\Presupuesto\Aggregates\Presupuesto as PresupuestoAggregate;
use App\Domains\Presupuesto\Contracts\Checkers\PresupuestoUniquenessCheckerContract;
use App\Domains\Presupuesto\Contracts\Repositories\PresupuestoRepositoryContract;
use App\Domains\Presupuesto\ValueObjects\PresupuestoId;
use App\Domains\Categoria\ValueObjects\CategoriaId;
use App\Shared\Domain\Contracts\IdGeneratorContract;
use App\Shared\Domain\ValueObjects\Date;
use DateTimeImmutable;
use App\Shared\Domain\ValueObjects\Amount;
use App\Domains\Usuario\ValueObjects\UsuarioId;
use App\Shared\Application\Contracts\Bus\EventBus;
use App\Shared\Application\Events\AuditableActionOcurred;
use App\Domains\Auditoria\Enums\AuditableActions;
use App\Domains\Auditoria\Enums\AuditableTypes;

final readonly class StorePresupuestoHandler
{
    public function __construct(
        private PresupuestoRepositoryContract $repository,
        private PresupuestoUniquenessCheckerContract $uniquenessChecker,
        private IdGeneratorContract $idGenerator,
        private EventBus $eventBus
    ) {}


    public function __invoke(StorePresupuestoCommand $command)
    {
        $presupuesto = PresupuestoAggregate::create(
            id: PresupuestoId::generate($this->idGenerator),
            categoria_id: new CategoriaId($command->categoria_id),
            monto: new Amount((float) $command->monto),
            periodo: new Date(new DateTimeImmutable()),
            descripcion: $command->descripcion,
            user_id: new UsuarioId($command->user_id),
            checker: $this->uniquenessChecker
        );

        $stored = $this->repository->store($presupuesto);

        $this->eventBus->publish(new AuditableActionOcurred(
            old_aggregate: null,
            new_aggregate: $stored,
            type: AuditableTypes::PRESUPUESTOS,
            action: AuditableActions::CREATE
        ));

        return $stored;
    }
}
