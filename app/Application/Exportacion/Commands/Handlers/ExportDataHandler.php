<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */

namespace App\Application\Exportacion\Commands\Handlers;

use App\Application\Exportacion\Commands\ExportDataCommand;
use App\Application\Exportacion\Commands\StoreExportacionCommand;
use App\Application\Exportacion\Contracts\Services\ExportFileServiceContract;
use App\Application\Exportacion\DTOs\GeneratedFileToExportDTO;
use App\Application\Exportacion\Queries\ExportDataQuery;
use App\Domains\Usuario\ValueObjects\UsuarioId;
use App\Shared\Application\Contracts\Bus\CommandBus;
use App\Shared\Application\Contracts\Bus\QueryBus;

/**
 * Handler wrapper que orquesta el caso de uso completo de exportación:
 * 1. Obtiene los datos vía QueryBus (usando el ExportQueryResolver)
 * 2. Persiste el log vía CommandBus interno
 * 3. Genera el archivo vía el servicio de exportación
 * 4. Devuelve el DTO con el callback de streaming
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.1.0
 *
 * @version 1.1.0
 */
final readonly class ExportDataHandler
{
    public function __construct(
        private QueryBus $queryBus,
        private CommandBus $commandBus,
        private ExportFileServiceContract $exportFileService,
    ) {}

    public function __invoke(ExportDataCommand $command): GeneratedFileToExportDTO
    {
        $query = new ExportDataQuery(
            table: $command->table,
            filters: $command->filters,
            visibleIds: $command->visibleIds,
            format: $command->format,
            onlyCurrentPage: $command->onlyCurrentPage,
        );

        $exportData = $this->queryBus->ask($query);

        $storeLogCommand = new StoreExportacionCommand(
            userId: new UsuarioId($command->userId),
            table: $command->table,
            format: $command->format,
            recordsCount: $exportData->rows->count(),
            filters: $command->filters,
            filename: $command->filename,
        );

        $export = $this->commandBus->dispatch($storeLogCommand);

        return $this->exportFileService->stream($exportData, $export);
    }
}
