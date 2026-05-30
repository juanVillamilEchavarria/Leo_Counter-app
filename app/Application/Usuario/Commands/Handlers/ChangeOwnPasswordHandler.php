<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Usuario\Commands\Handlers;

use App\Application\Usuario\Commands\ChangeOwnPasswordCommand;
use App\Application\Usuario\Exceptions\CannotFindUsuarioException;
use App\Domains\Usuario\Contracts\Repositories\UsuarioRepositoryContract;
use App\Domains\Usuario\Contracts\Services\PasswordHasherContract;
use App\Domains\Usuario\ValueObjects\UsuarioId;
use App\Shared\Domain\ValueObjects\Password;

/**
 * Handler del comando de cambio de contraseña del usuario.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Usuario\Commands\Handlers
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class ChangeOwnPasswordHandler
{
    public function __construct(
        private UsuarioRepositoryContract $repository,
        private PasswordHasherContract $hasher,
    ) {
    }

    public function __invoke(ChangeOwnPasswordCommand $command): bool
    {
        $usuario = $this->repository->findById(new UsuarioId($command->id));

        if (!$usuario) {
            throw new CannotFindUsuarioException();
        }

        $usuario = $usuario->changeOwnPassword(
            currentPassword: $command->currentPassword,
            newPassword: Password::create($command->newPassword),
            hasher: $this->hasher,
        );

        return $this->repository->update($usuario);
    }
}
