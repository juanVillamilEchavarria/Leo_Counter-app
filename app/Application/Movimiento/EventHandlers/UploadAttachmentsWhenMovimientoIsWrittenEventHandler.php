<?php

namespace App\Application\Movimiento\EventHandlers;

use App\Application\ArchivoMovimiento\Builders\FilePathBuilder;
use App\Application\ArchivoMovimiento\Commands\StoreArchivoMovimientoCommand;
use App\Application\Movimiento\Validators\MovimientoAttachmentValidator;
use App\Domains\Movimiento\Contracts\Events\UploadAttachmentsForMovimientoEventContract;
use App\Shared\Application\Contracts\Bus\CommandBus;
use App\Domains\Categoria\Contracts\Repositories\CategoriaRepositoryContract;
use App\Shared\Application\Contracts\Queries\Executors\GetTipoMovimientoNameQueryExecutorContract;

/**
 * Manejador de la subida de archivos cuando se dispara el evento de un movimiento creado
 */
final readonly class UploadAttachmentsWhenMovimientoIsWrittenEventHandler
{
    public function __construct(
        private CommandBus $commandBus,
        private MovimientoAttachmentValidator $movimientoAttachmentValidator,
        private CategoriaRepositoryContract $categoriaRepository,
        private GetTipoMovimientoNameQueryExecutorContract $tipoMovimientoName
    )
    {
    }

    public function __invoke(UploadAttachmentsForMovimientoEventContract $event): void
    {
        $movimiento = $event->getMovimiento();

        $categoria = $this->categoriaRepository->findById($movimiento->getCategoriaId());
        $tipoMovimientoName = $this->tipoMovimientoName->getName($movimiento->getTipoMovimientoId());

        $filePath = FilePathBuilder::buildFromNow(
            $tipoMovimientoName,
            $categoria->getNombre()
        );

        $this->movimientoAttachmentValidator->validateNumberOfFiles(count($event->getComprobantes()));
        foreach($event->getComprobantes() as $comprobante){
            $archivoCommand= new StoreArchivoMovimientoCommand(
                movimiento_id: $event->getMovimiento()->getId(),
                file: $comprobante,
                file_path: $filePath
            );
            $this->commandBus->dispatch($archivoCommand);

        }
    }

}
