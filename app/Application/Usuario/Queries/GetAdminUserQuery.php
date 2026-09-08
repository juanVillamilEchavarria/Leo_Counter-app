<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */

namespace App\Application\Usuario\Queries;

use App\Shared\Application\Contracts\Queries\QueryContract;

/**
 * Query que representa la intención de obtener el usuario administrador del sistema.
 * No recibe parámetros porque solo existe un administrador en el sistema.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.1.0
 *
 * @version 1.1.0
 */
final readonly class GetAdminUserQuery implements QueryContract {}
