<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Movimiento\EventHandlers;

use App\Application\ArchivoMovimiento\Commands\DestroyArchivoMovimientoCommand;
use App\Domains\ArchivoMovimiento\ValueObjects\ArchivoMovimientoId;
use App\Domains\Movimiento\Contracts\Events\DestroyAttachmentsForMovimientoEventContract;
use App\Shared\Application\Contracts\Bus\CommandBus;

/**
 * Manejador de eventos para la eliminacion de archivos relacionado a un movimiento.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Movimiento\EventHandlers
 * @version 1.0.0
 */
final readonly class DestroyAttachmentsWhenMovimientoIsWrittenEventHandler
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
