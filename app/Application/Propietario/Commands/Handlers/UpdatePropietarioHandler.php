<?php

namespace App\Application\Propietario\Commands\Handlers;

use App\Application\Propietario\Commands\UpdatePropietarioCommand;
use App\Domains\Propietario\Aggregates\Propietario as PropietarioAggregate;
use App\Domains\Propietario\Contracts\PropietarioUniquenessCheckerContract;
use App\Domains\Propietario\Contracts\Repositories\PropietarioRepositoryContract;
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
        $existing = $this->repository->findById($command->id);
        if (!$existing) {
            throw new \RuntimeException('Propietario no encontrado.');
        }

        assert($existing instanceof PropietarioAggregate);

        $updated = $existing->updateData(
            nombre: $command->nombre,
            apellido: $command->apellido,
            telefono: $command->telefono,
            email: new Email(trim($command->email)),
            checker: $this->checker,
            excludeId: $command->id,
        );

        return $this->repository->update($updated, $command->id);
    }
}
