<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */

namespace App\Application\Usuario\Queries\Handlers;

use App\Application\Usuario\Contracts\Queries\Executors\GetAdminUserQueryExecutorContract;
use App\Application\Usuario\Queries\GetAdminUserQuery;
use App\Domains\Usuario\Aggregates\Usuario;

/**
 * Handler que obtiene el usuario administrador del sistema.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.1.0
 *
 * @version 1.1.0
 */
final readonly class GetAdminUserHandler
{
    public function __construct(
        private GetAdminUserQueryExecutorContract $executor,
    ) {}

    public function __invoke(GetAdminUserQuery $query): ?Usuario
    {
        return $this->executor->execute();
    }
}
