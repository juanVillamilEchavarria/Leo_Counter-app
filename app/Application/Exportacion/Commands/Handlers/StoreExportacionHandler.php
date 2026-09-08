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

use App\Application\Exportacion\Commands\StoreExportacionCommand;
use App\Application\Exportacion\Contracts\Repositories\ExportacionRepositoryContract;
use App\Application\Exportacion\Events\TooManyRecordsExported;
use App\Application\Exportacion\Mappers\ExportTableQueryMapper;
use App\Domains\Exportacion\Aggregate\Exportacion;
use App\Shared\Application\Contracts\Bus\EventBus;
use App\Shared\Domain\Contracts\IdGeneratorContract;

/**
 * Handler que persiste el log de una exportación en la base de datos.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.1.0
 *
 * @version 1.1.0
 */
final readonly class StoreExportacionHandler
{
    public function __construct(
        private ExportacionRepositoryContract $exportacionRepository,
        private IdGeneratorContract $idGenerator,
        private EventBus $eventBus
    ) {}

    public function __invoke(StoreExportacionCommand $command): Exportacion
    {
        $filtersArray = ($command->filters !== null && $command->filters !== []) ? (new ExportTableQueryMapper)->mapToArray($command->filters) : [];
        $export = Exportacion::create(
            userId: $command->userId,
            table: $command->table,
            format: $command->format,
            recordsCount: $command->recordsCount,
            idGenerator: $this->idGenerator,
            filters: $filtersArray,
            filename: $command->filename,
        );

        $this->exportacionRepository->store($export);

        if ($export->tooManyRecords()) {
            $this->eventBus->publish(new TooManyRecordsExported($export));
        }

        return $export;
    }
}
