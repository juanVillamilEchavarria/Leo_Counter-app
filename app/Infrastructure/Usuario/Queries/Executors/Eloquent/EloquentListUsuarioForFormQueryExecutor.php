<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Infrastructure\Usuario\Queries\Executors\Eloquent;

use App\Shared\Application\Contracts\Queries\Executors\FormOptions\ListUsuarioForFormContract;
use App\Shared\Domain\Contracts\CollectionContract;
use App\Models\User;
use App\Shared\Infrastructure\Framework\Laravel\Collections\LaravelCollection;

/**
 * Executor que obtiene la lista de usuarios para un formulario
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class EloquentListUsuarioForFormQueryExecutor implements ListUsuarioForFormContract
{

    /**
     * @inheritDoc
     */
    public function execute(): CollectionContract
    {
        $usuarios = User::query()->select('users.id', 'users.name', 'users.email');
        return new LaravelCollection($usuarios->get());

    }
}
