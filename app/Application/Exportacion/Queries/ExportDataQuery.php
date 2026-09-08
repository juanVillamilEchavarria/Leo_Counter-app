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

use App\Domains\Exportacion\Enums\ExportableTable;
use App\Domains\Exportacion\Enums\ExportFormat;
use App\Shared\Application\Contracts\Queries\QueryContract;
use App\Shared\Application\Queries\TableQuery;

/**
 * Query principal de exportación de datos.
 * Representa la intención de exportar una tabla (server-side o client-side) a CSV o Excel.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.1.0
 *
 * @version 1.1.0
 */
final readonly class ExportDataQuery implements QueryContract
{
    public function __construct(
        /** @var ExportableTable Tabla que se desea exportar */
        public ExportableTable $table,
        /** @var TableQuery|null Filtros para tablas server-side */
        public ?TableQuery $filters = null,
        /** @var array<int, string>|null IDs visibles para tablas client-side */
        public ?array $visibleIds = null,
        /** @var ExportFormat Formato del archivo de salida */
        public ExportFormat $format = ExportFormat::CSV,
        /** @var bool true = solo la página actual, false = todos los registros que matchean */
        public bool $onlyCurrentPage = false,
        /** @var string|null Nombre sugerido del archivo */
        public ?string $filename = null,
    ) {}
}
