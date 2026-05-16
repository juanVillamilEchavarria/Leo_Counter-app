<?php

namespace App\Infrastructure\Movimiento\EventHandlers\Laravel;

use App\Application\ArchivoMovimiento\Builders\FilePathBuilder;
use App\Application\ArchivoMovimiento\Commands\UpdateArchivoMovimientoCommand;
use App\Application\Movimiento\Contracts\EventHandlers\UpdateAttachmentsWhenMovimientoIsWrittenEventHandlerContract;
use App\Domains\ArchivoMovimiento\ValueObjects\ArchivoMovimientoId;
use App\Domains\Movimiento\Contracts\Events\UpdateAttachmentsForMovimientoEventContract;
use App\Domains\Movimiento\Contracts\Events\UploadAttachmentsForMovimientoEventContract;
use App\Shared\Application\Contracts\Bus\CommandBus;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Manejador de eventos para la actualizacion de archivos relacionado a un movimiento.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Infrastructure\Movimiento\EventHandlers\Laravel
 * @version 1.0.0
 */
final readonly class LaravelUpdateAttachmentsWhenMovimientoIsWrittenEventHandler implements UpdateAttachmentsWhenMovimientoIsWrittenEventHandlerContract, ShouldQueue
{
public function __construct(
    private CommandBus $commandBus
)
{
}

    public function __invoke(UpdateAttachmentsForMovimientoEventContract $event): void
    {
        if(!is_array($event->getComprobantesExisting())) return;
        $filePath = FilePathBuilder::buildFromNow(
            tipo_movimiento: $event->getTipoMovimientoName(),
            categoria: $event->getCategoria()->getNombre()
        );
        foreach($event->getComprobantesExisting() as $comp_exist){
            $id = new ArchivoMovimientoId($comp_exist);
            $this->commandBus->dispatch(new UpdateArchivoMovimientoCommand(
                id: $id,
                filePath: $filePath
            ));
        }
    }
}
