<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */

namespace App\Application\Exportacion\Contracts\Queries\Executors;

use App\Shared\Application\Contracts\Queries\Executors\PaginatedTableQueryExecutorContract;

/**
 * Contrato que debe implementar el executor de paginación de tablas de exportaciones.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.1.0
 *
 * @version 1.1.0
 */
interface ExportacionPaginatedTableQueryExecutorContract extends PaginatedTableQueryExecutorContract {}
