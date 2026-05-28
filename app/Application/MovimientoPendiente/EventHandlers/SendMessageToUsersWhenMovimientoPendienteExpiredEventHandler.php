<?php

namespace App\Application\MovimientoPendiente\EventHandlers;

use App\Domains\MovimientoPendiente\Events\MovimientoPendienteExpired;
use App\Shared\Application\Resolvers\SendMessageToUsersByChannelsResolver;

/**
 * Manejador del envio de mensaje para cuando un movimiento pendiente ha expirado.
 * @package App\Application\MovimientoPendiente\EventHandlers
 * @since 1.0.0
 * @version 1.0.0
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @see MovimientoPendienteExpired
 */
final readonly class SendMessageToUsersWhenMovimientoPendienteExpiredEventHandler
{
    public function __construct(
        private  SendMessageToUsersByChannelsResolver $sendMessageToUserByChannelResolver
    )
    {
    }
    public function __invoke( MovimientoPendienteExpired $event): void
    {
        $this->sendMessageToUserByChannelResolver->resolve($event);
    }

}
