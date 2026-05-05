<?php

namespace App\Application\Propietario\Commands\Handlers;

use App\Application\Propietario\Commands\DestroyPropietarioCommand;
use App\Domains\Propietario\Contracts\PropietarioHasCuentasCheckerContract;
use App\Domains\Propietario\Contracts\Repositories\PropietarioRepositoryContract;
use App\Domains\Propietario\Exceptions\CannotDeletePropietarioException;

/**
 * Handler para la eliminación de un propietario.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Propietario\Commands\Handlers
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class DestroyPropietarioHandler
{
    public function __construct(
        private PropietarioRepositoryContract $repository,
        private PropietarioHasCuentasCheckerContract $checker,
    ) {}

    public function __invoke(DestroyPropietarioCommand $command) : bool
    {
        if ($this->checker->hasCuentas($command->id)) {
            throw new CannotDeletePropietarioException('No se puede eliminar el propietario, tiene cuentas asociadas');
        }

        return $this->repository->destroy($command->id);
    }
}
