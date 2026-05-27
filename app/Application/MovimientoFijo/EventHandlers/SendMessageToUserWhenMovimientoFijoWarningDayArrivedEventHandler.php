<?php

namespace App\Application\MovimientoFijo\EventHandlers;

use App\Domains\MovimientoFijo\Events\MovimientoFijoWarningDayArrived;
use App\Shared\Application\Resolvers\SendMessageToUsersByChannelsResolver;

/**
 * manejador de evento para enviar un mensaje al usuario cuando el dia de aviso de un movimiento fijo ha llegado
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class SendMessageToUserWhenMovimientoFijoWarningDayArrivedEventHandler
{
    public function __construct(
        private  SendMessageToUsersByChannelsResolver $sendMessageToUserByChannelResolver
    )
    {
    }
    public function __invoke( MovimientoFijoWarningDayArrived $event): void
    {
        $this->sendMessageToUserByChannelResolver->resolve($event);
    }

}
