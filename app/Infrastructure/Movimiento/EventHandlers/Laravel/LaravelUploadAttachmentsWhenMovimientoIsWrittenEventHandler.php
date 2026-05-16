<?php

namespace App\Infrastructure\Movimiento\EventHandlers\Laravel;
use App\Application\ArchivoMovimiento\Builders\FilePathBuilder;
use App\Application\ArchivoMovimiento\Commands\StoreArchivoMovimientoCommand;
use App\Domains\Movimiento\Contracts\Events\UploadAttachmentsForMovimientoEventContract;
use App\Shared\Application\Contracts\Bus\CommandBus;
use App\Application\Movimiento\Contracts\EventHandlers\UploadAttachmentsWhenMovimientoIsWrittenEventHandlerContract;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Manejador de la subida de archivos cuando se dispara el evento de un movimiento creado
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class LaravelUploadAttachmentsWhenMovimientoIsWrittenEventHandler implements  UploadAttachmentsWhenMovimientoIsWrittenEventHandlerContract, ShouldQueue
{
    public function __construct(
        private CommandBus $commandBus
    )
    {
    }
    public function __invoke(UploadAttachmentsForMovimientoEventContract $event): void
    {
        $filePath = FilePathBuilder::buildFromNow(
            $event->getTipoMovimientoName(),
            $event->getCategoria()->getNombre()
        );
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
