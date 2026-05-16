<?php

namespace App\Application\Movimiento\EventHandlers;

use App\Application\ArchivoMovimiento\Builders\FilePathBuilder;
use App\Application\ArchivoMovimiento\Commands\UpdateArchivoMovimientoCommand;
use App\Domains\ArchivoMovimiento\ValueObjects\ArchivoMovimientoId;
use App\Domains\Movimiento\Contracts\Events\UpdateAttachmentsForMovimientoEventContract;
use App\Shared\Application\Contracts\Bus\CommandBus;

/**
 * Manejador de eventos para la actualizacion de archivos relacionado a un movimiento.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Movimiento\EventHandlers
 * @version 1.0.0
 */
final readonly class UpdateAttachmentsWhenMovimientoIsWrittenEventHandler
{
public function __construct(
    private CommandBus $commandBus
)
{
}

    public function __invoke(UpdateAttachmentsForMovimientoEventContract $event): void
    {
        if(!$event->pathChanged())return ;
        if(!is_array($event->getComprobantesExisting())) return;
        $filePath = FilePathBuilder::buildFromNow(
            tipo_movimiento: $event->getTipoMovimientoName(),
            categoria: $event->getCategoria()->getNombre()
        );
        foreach($event->getComprobantesExisting() as $comp_exist){
            $id = new ArchivoMovimientoId($comp_exist['id']);
            $this->commandBus->dispatch(new UpdateArchivoMovimientoCommand(
                id: $id,
                filePath: $filePath
            ));
        }
    }
}
