<?php

namespace App\Infrastructure\Usuario\Queries\Executors\Eloquent;

use App\Application\Usuario\Contracts\Queries\Executors\UsuarioQueryExecutorContract;
use App\Models\User;
use App\Shared\Domain\Contracts\CollectionContract;
use App\Shared\Infrastructure\Framework\Laravel\Collections\LaravelCollection;

/**
 * Executor Eloquent para listar todos los usuarios sin relaciones.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Infrastructure\Usuario\Queries\Executors\Eloquent
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class EloquentListAllUsuariosExecutor implements UsuarioQueryExecutorContract
{
    public function execute(): CollectionContract
    {
        return new LaravelCollection(
            User::query()
                ->select('id', 'name', 'email', 'role', 'created_at', 'updated_at')
                ->get()
        );
    }
}
