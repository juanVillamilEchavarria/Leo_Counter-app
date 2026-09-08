<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */

namespace App\Application\Exportacion\Queries;

use App\Shared\Application\Queries\TableQuery;

/**
 * Query concreta que transporta los filtros genéricos de una tabla server-side
 * hacia la exportación. Al construirla se reutilizan únicamente las propiedades
 * base de {@see TableQuery} (search, perPage, sortBy, sortOrder, page).
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.1.0
 *
 * @version 1.1.0
 */
final readonly class ExportTableQuery extends TableQuery {}
