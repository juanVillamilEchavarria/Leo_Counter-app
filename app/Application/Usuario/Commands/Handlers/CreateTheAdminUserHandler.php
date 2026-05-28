<?php

namespace App\Application\Usuario\Commands\Handlers;

use App\Application\Usuario\Commands\CreateTheAdminUserCommand;
use App\Domains\Usuario\Aggregates\Usuario;
use App\Domains\Usuario\Contracts\Repositories\UsuarioRepositoryContract;
use App\Shared\ValueObjects\Password;
use App\Shared\Domain\ValueObjects\Email;
use App\Domains\Usuario\ValueObjects\UsuarioId;
use App\Domains\Usuario\Contracts\Checkers\UsuarioUniquinessCheckerContract;
use App\Shared\Domain\Contracts\IdGeneratorContract;
final readonly class CreateTheAdminUserHandler
{
    public function __construct(
        private UsuarioRepositoryContract $repository,
        private UsuarioUniquinessCheckerContract $checker,
        private IdGeneratorContract $idGenerator
    )
    {
    }
    public function __invoke(CreateTheAdminUserCommand $command): void
    {
        $admin = Usuario::createAdmin(
            id: UsuarioId::generate($this->idGenerator),
            name: $command->name,
            email: new Email($command->email),
            password: Password::create($command->password),
            checker: $this->checker
        );
        $this->repository->store($admin);
    }

}
