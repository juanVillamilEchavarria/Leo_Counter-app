<?php

namespace App\Infrastructure\Movimiento\EventHandlers\Laravel;

use App\Application\ArchivoMovimiento\Commands\DestroyArchivoMovimientoCommand;
use App\Application\Movimiento\Contracts\EventHandlers\DestroyAttachmentsWhenMovimientoIsWrittenEventHandlerContract;
use App\Domains\ArchivoMovimiento\ValueObjects\ArchivoMovimientoId;
use App\Domains\Movimiento\Contracts\Events\DestroyAttachmentsForMovimientoEventContract;
use App\Shared\Application\Contracts\Bus\CommandBus;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Manejador de eventos para la eliminacion de archivos relacionado a un movimiento.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Infrastructure\Movimiento\EventHandlers\Laravel
 * @version 1.0.0
 */
final readonly class LaravelDestroyAttachmentsWhenMovimientoIsWrittenEventHadler implements DestroyAttachmentsWhenMovimientoIsWrittenEventHandlerContract, ShouldQueue
{
    public function __construct(
        private CommandBus $commandBus,
    )
    {
    }

    public function __invoke(DestroyAttachmentsForMovimientoEventContract $event): void
    {
        if(!is_array($event->getComprobantesDeleteIds())) return;
        foreach ($event->getComprobantesDeleteIds() as $comp_delete_id){
            $id = new ArchivoMovimientoId($comp_delete_id);
            $this->commandBus->dispatch(new DestroyArchivoMovimientoCommand(
                id: $id
            ));
        }
    }
}
