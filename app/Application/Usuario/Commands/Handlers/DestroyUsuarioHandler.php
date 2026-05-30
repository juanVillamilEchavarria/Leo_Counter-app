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

use App\Application\Usuario\Commands\DestroyUsuarioCommand;
use App\Application\Usuario\Exceptions\CannotDeleteUsuarioException;
use App\Application\Usuario\Exceptions\CannotFindUsuarioException;
use App\Domains\Usuario\Aggregates\Usuario;
use App\Domains\Usuario\Contracts\Repositories\UsuarioRepositoryContract;
use App\Domains\Usuario\Enums\Roles;
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
        /** @var Usuario $usuario */
        $usuario = $this->repository->findById(new UsuarioId($command->id));
        if (!$usuario) {
            throw new CannotFindUsuarioException();
        }
        if($usuario->isAdmin()){
            throw new CannotDeleteUsuarioException('No se puede eliminar el usuario administrador');
        }
        return $this->repository->destroy(new UsuarioId($command->id));
    }
}
