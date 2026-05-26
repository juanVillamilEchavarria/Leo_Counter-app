<?php

namespace App\Application\Usuario\Queries\Handlers;

use App\Application\Usuario\DTOs\UsuarioEditDTO;
use App\Application\Usuario\Exceptions\CannotFindUsuarioException;
use App\Application\Usuario\Queries\GetUsuarioForEditQuery;
use App\Domains\Usuario\Aggregates\Usuario;
use App\Domains\Usuario\Contracts\Repositories\UsuarioRepositoryContract;
use App\Domains\Usuario\ValueObjects\UsuarioId;
use App\Domains\Usuario\Contracts\Checkers\UsuarioCanUpdatePublicDataCheckerContract;

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
        private UsuarioCanUpdatePublicDataCheckerContract $checker
    ) {
    }

    public function __invoke(GetUsuarioForEditQuery $query): UsuarioEditDTO
    {
        /** @var Usuario $usuario */
        $usuario = $this->repository->findById(new UsuarioId($query->id));

        if (!$usuario) {
            throw new CannotFindUsuarioException();
        }

        return new UsuarioEditDTO(
            id: $usuario->getId()->getValue(),
            name: $usuario->getName(),
            email: $usuario->getEmail(),
            isSuscribed: !$this->checker->userCanUpdateHisPublicDataRelatedToANotificationChannel($usuario->getId())
        );
    }
}
