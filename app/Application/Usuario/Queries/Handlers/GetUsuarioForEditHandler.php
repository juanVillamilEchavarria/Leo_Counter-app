<?php

namespace App\Application\Usuario\Queries\Handlers;

use App\Application\Usuario\DTOs\UsuarioEditDTO;
use App\Application\Usuario\Exceptions\CannotFindUsuarioException;
use App\Application\Usuario\Queries\GetUsuarioForEditQuery;
use App\Domains\Usuario\Contracts\Repositories\UsuarioRepositoryContract;
use App\Domains\Usuario\ValueObjects\UsuarioId;

/**
 * Handler para obtener los datos de edición del usuario.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Usuario\Queries\Handlers
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class GetUsuarioForEditHandler
{
    public function __construct(
        private UsuarioRepositoryContract $repository,
    ) {
    }

    public function __invoke(GetUsuarioForEditQuery $query): UsuarioEditDTO
    {
        $usuario = $this->repository->findById(new UsuarioId($query->id));

        if (!$usuario) {
            throw new CannotFindUsuarioException();
        }

        return new UsuarioEditDTO(
            id: $usuario->getId()->getValue(),
            name: $usuario->getName(),
            email: $usuario->getEmail(),
        );
    }
}
