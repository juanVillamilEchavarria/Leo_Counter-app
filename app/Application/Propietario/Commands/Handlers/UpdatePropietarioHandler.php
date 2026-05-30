<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Propietario\Commands\Handlers;

use App\Application\Propietario\Commands\UpdatePropietarioCommand;
use App\Domains\Propietario\Aggregates\Propietario as PropietarioAggregate;
use App\Domains\Propietario\Contracts\PropietarioUniquenessCheckerContract;
use App\Domains\Propietario\Contracts\Repositories\PropietarioRepositoryContract;
use App\Domains\Propietario\Exceptions\CannotFindPropietarioException;
use App\Domains\Propietario\ValueObjects\PropietarioId;
use App\Shared\Domain\ValueObjects\Email;

/**
 * Handler para la actualización de un propietario.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Propietario\Commands\Handlers
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class UpdatePropietarioHandler
{
    public function __construct(
        private PropietarioRepositoryContract $repository,
        private PropietarioUniquenessCheckerContract $checker,
    ) {}

    public function __invoke(UpdatePropietarioCommand $command) : bool
    {
        $propietarioId = new PropietarioId($command->id);
        $existing = $this->repository->findById($propietarioId);
        if (!$existing) {
            throw new CannotFindPropietarioException();
        }

        assert($existing instanceof PropietarioAggregate);

        $updated = $existing->updateData(
            nombre: $command->nombre,
            apellido: $command->apellido,
            telefono: $command->telefono,
            email: new Email(trim($command->email)),
            checker: $this->checker,
        );

        return $this->repository->update($updated);
    }
}
