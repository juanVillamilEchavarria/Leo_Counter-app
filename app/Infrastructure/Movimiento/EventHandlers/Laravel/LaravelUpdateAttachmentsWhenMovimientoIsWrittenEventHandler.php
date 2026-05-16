<?php

/**
 * Archivo comentado - implementacion movida a App\Application\Movimiento\EventHandlers\UpdateAttachmentsWhenMovimientoIsWrittenEventHandler
 *
 * Este archivo se conserva comentado por trazabilidad antes de su eliminación.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Infrastructure\Movimiento\EventHandlers\Laravel
 * @version 1.0.0
 */

// final readonly class LaravelUpdateAttachmentsWhenMovimientoIsWrittenEventHandler implements UpdateAttachmentsWhenMovimientoIsWrittenEventHandlerContract, ShouldQueue
// {
// public function __construct(
//     private CommandBus $commandBus
// )
// {
// }
//
//     public function __invoke(UpdateAttachmentsForMovimientoEventContract $event): void
//     {
//         if(!$event->pathChanged())return ;
//         if(!is_array($event->getComprobantesExisting())) return;
//         $filePath = FilePathBuilder::buildFromNow(
//             tipo_movimiento: $event->getTipoMovimientoName(),
//             categoria: $event->getCategoria()->getNombre()
//         );
//         foreach($event->getComprobantesExisting() as $comp_exist){
//             $id = new ArchivoMovimientoId($comp_exist['id']);
//             $this->commandBus->dispatch(new UpdateArchivoMovimientoCommand(
//                 id: $id,
//                 filePath: $filePath
//             ));
//         }
//     }
//}
