<?php

/**
 * Archivo comentado - implementacion movida a App\Application\Movimiento\EventHandlers\UploadAttachmentsWhenMovimientoIsWrittenEventHandler
 *
 * Este archivo se conserva comentado por trazabilidad antes de su eliminación.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Infrastructure\Movimiento\EventHandlers\Laravel
 * @since 1.0.0
 * @version 1.0.0
 */

// final readonly class LaravelUploadAttachmentsWhenMovimientoIsWrittenEventHandler implements  UploadAttachmentsWhenMovimientoIsWrittenEventHandlerContract, ShouldQueue
// {
//     public function __construct(
//         private CommandBus $commandBus
//     )
//     {
//     }
//     public function __invoke(UploadAttachmentsForMovimientoEventContract $event): void
//     {
//         $filePath = FilePathBuilder::buildFromNow(
//             $event->getTipoMovimientoName(),
//             $event->getCategoria()->getNombre()
//         );
//         foreach($event->getComprobantes() as $comprobante){
//             $archivoCommand= new StoreArchivoMovimientoCommand(
//                 movimiento_id: $event->getMovimiento()->getId(),
//                 file: $comprobante,
//                 file_path: $filePath
//             );
//             $this->commandBus->dispatch($archivoCommand);
//
//         }
//     }
//
// }
