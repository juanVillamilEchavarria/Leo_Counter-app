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

use App\Application\Usuario\Commands\CreateTheAdminUserCommand;
use App\Domains\Usuario\Aggregates\Usuario;
use App\Domains\Usuario\Contracts\Checkers\UsuarioUniquinessCheckerContract;
use App\Domains\Usuario\Contracts\Repositories\UsuarioRepositoryContract;
use App\Domains\Usuario\ValueObjects\UsuarioId;
use App\Shared\Domain\Contracts\IdGeneratorContract;
use App\Shared\Domain\ValueObjects\Email;
use App\Shared\Domain\ValueObjects\Password;

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
