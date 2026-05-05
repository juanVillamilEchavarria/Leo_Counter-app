<?php

namespace App\Application\Propietario\Commands\Handlers;

use App\Application\Propietario\Commands\StorePropietarioCommand;
use App\Domains\Propietario\Aggregates\Propietario;
use App\Domains\Propietario\Contracts\PropietarioUniquenessCheckerContract;
use App\Domains\Propietario\Contracts\Repositories\PropietarioRepositoryContract;
use App\Shared\Domain\Contracts\AggregateModelContract;
use App\Shared\Domain\ValueObjects\Email;

/**
 * Handler para la creación de un propietario.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Propietario\Commands\Handlers
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class StorePropietarioHandler
{
    public function __construct(
        private PropietarioRepositoryContract $repository,
        private PropietarioUniquenessCheckerContract $checker,
    ) {}

    public function __invoke(StorePropietarioCommand $command) : AggregateModelContract
    {
        $propietario = Propietario::create(
            nombre: $command->nombre,
            apellido: $command->apellido,
            telefono: $command->telefono,
            email: new Email(trim($command->email)),
            checker: $this->checker,
        );

        return $this->repository->store($propietario);
    }
}
