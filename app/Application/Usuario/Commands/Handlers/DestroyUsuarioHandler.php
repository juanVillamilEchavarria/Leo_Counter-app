<?php

namespace App\Application\Usuario\Commands\Handlers;

use App\Application\Usuario\Commands\DestroyUsuarioCommand;
use App\Domains\Usuario\Contracts\Repositories\UsuarioRepositoryContract;
use App\Domains\Usuario\ValueObjects\UsuarioId;

/**
 * Handler del comando de eliminación de usuarios.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Usuario\Commands\Handlers
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class DestroyUsuarioHandler
{
    public function __construct(
        private UsuarioRepositoryContract $repository,
    ) {
    }

    public function __invoke(DestroyUsuarioCommand $command): bool
    {
        return $this->repository->destroy(new UsuarioId($command->id));
    }
}
