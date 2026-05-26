<?php

namespace App\Application\Usuario\Queries\Handlers;

use App\Application\Usuario\Contracts\Queries\Executors\UsuarioQueryExecutorContract;
use App\Application\Usuario\Queries\ListAllUsuariosQuery;
use App\Shared\Domain\Contracts\CollectionContract;

/**
 * Handler de la query de listado total de usuarios.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Usuario\Queries\Handlers
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class ListAllUsuariosHandler
{
    public function __construct(
        private UsuarioQueryExecutorContract $executor,
    ) {
    }

    public function __invoke(ListAllUsuariosQuery $query): CollectionContract
    {
        return $this->executor->execute();
    }
}
