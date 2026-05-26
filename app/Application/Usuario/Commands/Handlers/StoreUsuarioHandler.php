<?php

namespace App\Application\Usuario\Commands\Handlers;

use App\Application\Usuario\Commands\StoreUsuarioCommand;
use App\Domains\Usuario\Aggregates\Usuario;
use App\Domains\Usuario\Contracts\Repositories\UsuarioRepositoryContract;
use App\Domains\Usuario\ValueObjects\UsuarioId;
use App\Shared\Domain\Contracts\AggregateModelContract;
use App\Shared\Domain\Contracts\IdGeneratorContract;
use App\Shared\Domain\ValueObjects\Email;
use App\Shared\ValueObjects\Password;

/**
 * Handler del comando de creación administrativa de usuarios member.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Usuario\Commands\Handlers
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class StoreUsuarioHandler
{
    public function __construct(
        private UsuarioRepositoryContract $repository,
        private IdGeneratorContract $idGenerator,
    ) {
    }

    public function __invoke(StoreUsuarioCommand $command): AggregateModelContract
    {
        $usuario = Usuario::create(
            id: UsuarioId::generate($this->idGenerator),
            name: $command->name,
            email: new Email(trim($command->email)),
            password: Password::create($command->password),
        );

        return $this->repository->store($usuario);
    }
}
