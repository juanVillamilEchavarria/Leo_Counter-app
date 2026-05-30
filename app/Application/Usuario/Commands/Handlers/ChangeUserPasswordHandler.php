<?php

namespace App\Application\Usuario\Commands\Handlers;

use App\Application\Usuario\Commands\ChangeUserPasswordCommand;
use App\Application\Usuario\Exceptions\CannotChangeAdminPasswordException;
use App\Application\Usuario\Exceptions\CannotFindUsuarioException;
use App\Domains\Usuario\Contracts\Repositories\UsuarioRepositoryContract;
use App\Domains\Usuario\Contracts\Services\PasswordHasherContract;
use App\Domains\Usuario\ValueObjects\UsuarioId;
use App\Shared\Domain\ValueObjects\Password;

/**
 * Handler del cambio administrativo de contraseña de usuario.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Usuario\Commands\Handlers
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class ChangeUserPasswordHandler
{
    public function __construct(
        private UsuarioRepositoryContract $repository,
        private PasswordHasherContract $hasher,
    ) {
    }

    public function __invoke(ChangeUserPasswordCommand $command): bool
    {
        $usuario = $this->repository->findById(new UsuarioId($command->id));

        if (!$usuario) {
            throw new CannotFindUsuarioException();
        }
        if($usuario->isAdmin()){
            throw new CannotChangeAdminPasswordException('No se puede cambiar la contraseña del administrador');
        }
        $usuario = $usuario->changePassword(
            newPassword: Password::create($command->newPassword),
            hasher: $this->hasher,
        );

        return $this->repository->update($usuario);
    }
}
