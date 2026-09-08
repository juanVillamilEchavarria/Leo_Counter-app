<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */

namespace App\Application\Exportacion\Commands;

use App\Application\Exportacion\Queries\ExportTableQuery;
use App\Domains\Exportacion\Enums\ExportableTable;
use App\Domains\Exportacion\Enums\ExportFormat;

/**
 * Command principal de exportación. Orquesta la obtención de datos,
 * persistencia del log y generación del archivo para streaming directo.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.1.0
 *
 * @version 1.1.0
 */
final readonly class ExportDataCommand
{
    public function __construct(
        public string $userId,
        public ExportableTable $table,
        public ExportFormat $format,
        public ?ExportTableQuery $filters = null,
        public ?array $visibleIds = null,
        public bool $onlyCurrentPage = false,
        public ?string $filename = null,
    ) {}
}
