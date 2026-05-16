<?php

namespace App\Application\Movimiento\Contracts\EventHandlers;
use App\Domains\Movimiento\Contracts\Events\UploadAttachmentsForMovimientoEventContract;

/**
 * Contrato de manejar de evento para la subida de archivos relacionado a un movimiento.
 * se crea un contrato, ya que esta implementacion debe ser asincrona de la transacciom financiera.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Movimiento\Contracts\EventHandlers
 * @version 1.0.0
 */
interface UploadAttachmentsWhenMovimientoIsWrittenEventHandlerContract
{
    public function __invoke(UploadAttachmentsForMovimientoEventContract $event): void;

}
