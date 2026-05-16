<?php

/**
 * Archivo comentado - implementacion movida a App\Application\Movimiento\EventHandlers\DestroyAttachmentsWhenMovimientoIsWrittenEventHandler
 *
 * Este archivo se conserva comentado por trazabilidad antes de su eliminación.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Infrastructure\Movimiento\EventHandlers\Laravel
 * @version 1.0.0
 */

// final readonly class LaravelDestroyAttachmentsWhenMovimientoIsWrittenEventHadler implements DestroyAttachmentsWhenMovimientoIsWrittenEventHandlerContract, ShouldQueue
// {
//     public function __construct(
//         private CommandBus $commandBus,
//     )
//     {
//     }
//
//     public function __invoke(DestroyAttachmentsForMovimientoEventContract $event): void
//     {
//         if(!is_array($event->getComprobantesDeleteIds())) return;
//         foreach ($event->getComprobantesDeleteIds() as $comp_delete_id){
//             $id = new ArchivoMovimientoId($comp_delete_id);
//             $this->commandBus->dispatch(new DestroyArchivoMovimientoCommand(
//                 id: $id
//             ));
//         }
//     }
//}
