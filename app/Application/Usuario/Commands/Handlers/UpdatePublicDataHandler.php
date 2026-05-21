<?php

namespace App\Application\Usuario\Commands\Handlers;

use App\Application\Usuario\Commands\UpdatePublicDataCommand;
use App\Application\Usuario\Exceptions\CannotFindUsuarioException;
use App\Domains\Usuario\Contracts\Repositories\UsuarioRepositoryContract;
use App\Domains\Usuario\ValueObjects\UsuarioId;
use App\Shared\Domain\ValueObjects\Email;

/**
 * Handler del comando de actualización de datos públicos del usuario.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Usuario\Commands\Handlers
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class UpdatePublicDataHandler
{
    public function __construct(
        private UsuarioRepositoryContract $repository,
    ) {
    }

    public function __invoke(UpdatePublicDataCommand $command): bool
    {
        $usuario = $this->repository->findById(new UsuarioId($command->id));

        if (!$usuario) {
            throw new CannotFindUsuarioException();
        }

        $usuario = $usuario->updatePublicData(
            name: $command->name,
            email: new Email($command->email),
        );

        return $this->repository->update($usuario);
    }
}
