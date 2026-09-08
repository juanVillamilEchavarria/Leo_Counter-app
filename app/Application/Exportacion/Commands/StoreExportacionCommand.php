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
use App\Domains\Usuario\ValueObjects\UsuarioId;
use App\Shared\Application\Contracts\Commands\TransactionalCommandContract;

/**
 * Command interno para persistir el log de una exportación.
 * Es despachado por el ExportDataHandler (wrapper).
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.1.0
 *
 * @version 1.1.0
 */
final readonly class StoreExportacionCommand implements TransactionalCommandContract
{
    public function __construct(
        public UsuarioId $userId,
        public ExportableTable $table,
        public ExportFormat $format,
        public int $recordsCount,
        public ?ExportTableQuery $filters = null,
        public ?string $filename = null,
    ) {}
}
