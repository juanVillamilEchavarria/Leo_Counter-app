<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */

namespace App\Application\Usuario\Contracts\Queries\Executors;

use App\Domains\Usuario\Aggregates\Usuario;

/**
 * Contrato del executor que recupera el usuario administrador del sistema.
 * Retorna nullable para manejar el caso edge donde no exista admin configurado.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.1.0
 *
 * @version 1.1.0
 */
interface GetAdminUserQueryExecutorContract
{
    public function execute(): ?Usuario;
}
