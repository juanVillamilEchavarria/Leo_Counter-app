<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */

namespace App\Infrastructure\Usuario\Queries\Executors\Eloquent;

use App\Application\Usuario\Contracts\Queries\Executors\GetAdminUserQueryExecutorContract;
use App\Domains\Usuario\Aggregates\Usuario;
use App\Domains\Usuario\Enums\Roles;
use App\Domains\Usuario\ValueObjects\UsuarioId;
use App\Models\User;
use App\Shared\Domain\ValueObjects\Email;
use App\Shared\Domain\ValueObjects\Password;
use Override;

/**
 * Executor Eloquent que recupera el usuario administrador del sistema.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.1.0
 *
 * @version 1.1.0
 */
final readonly class EloquentGetAdminUserQueryExecutor implements GetAdminUserQueryExecutorContract
{
    #[Override]
    public function execute(): ?Usuario
    {
        $model = User::query()
            ->where('role', Roles::ADMIN->value)
            ->first();

        if ($model === null) {
            return null;
        }

        return Usuario::reconstitute(
            id: new UsuarioId($model->id),
            name: $model->name,
            email: new Email($model->email),
            password: Password::fromHash($model->password),
            role: Roles::try($model->role),
        );
    }
}
