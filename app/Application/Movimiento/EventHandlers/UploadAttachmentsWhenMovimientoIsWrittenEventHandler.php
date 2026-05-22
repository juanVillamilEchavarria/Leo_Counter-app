<?php

namespace App\Application\Movimiento\EventHandlers;

use App\Application\ArchivoMovimiento\Builders\FilePathBuilder;
use App\Application\ArchivoMovimiento\Commands\StoreArchivoMovimientoCommand;
use App\Application\Movimiento\Validators\MovimientoAttachmentValidator;
use App\Domains\Movimiento\Contracts\Events\UploadAttachmentsForMovimientoEventContract;
use App\Shared\Application\Contracts\Bus\CommandBus;

/**
 * Manejador de la subida de archivos cuando se dispara el evento de un movimiento creado
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class UploadAttachmentsWhenMovimientoIsWrittenEventHandler
{
    public function __construct(
        private CommandBus $commandBus,
        private MovimientoAttachmentValidator $movimientoAttachmentValidator
    )
    {
    }

    public function __invoke(UploadAttachmentsForMovimientoEventContract $event): void
    {
        $filePath = FilePathBuilder::buildFromNow(
            $event->getTipoMovimientoName(),
            $event->getCategoria()->getNombre()
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
