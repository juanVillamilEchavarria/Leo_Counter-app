<?php

namespace App\Application\Usuario\Commands\Handlers;

use App\Application\Usuario\Commands\ChangePasswordCommand;
use App\Application\Usuario\Exceptions\CannotFindUsuarioException;
use App\Domains\Usuario\Contracts\Repositories\UsuarioRepositoryContract;
use App\Domains\Usuario\Contracts\Services\PasswordHasherContract;
use App\Domains\Usuario\ValueObjects\UsuarioId;

/**
 * Handler del comando de cambio de contraseña del usuario.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Usuario\Commands\Handlers
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class ChangePasswordHandler
{
    public function __construct(
        private UsuarioRepositoryContract $repository,
        private PasswordHasherContract $hasher,
    ) {
    }

    public function __invoke(ChangePasswordCommand $command): bool
    {
        $usuario = $this->repository->findById(new UsuarioId($command->id));

        if (!$usuario) {
            throw new CannotFindUsuarioException();
        }

        $usuario = $usuario->changePassword(
            currentPassword: $command->currentPassword,
            newPassword: $command->newPassword,
            hasher: $this->hasher,
        );

        return $this->repository->update($usuario);
    }
}
