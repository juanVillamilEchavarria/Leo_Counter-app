<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\MovimientoPendiente\EventHandlers;

use App\Domains\MovimientoPendiente\Events\MovimientoPendienteWarningDayArrived;
use App\Shared\Application\Resolvers\SendMessageToUsersByChannelsResolver;

/**
 * Manejador del evento cuando un movimiento pendiente llego a su dia de aviso.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class SendMessageToUsersWhenMovimientoPendienteWarningDayArrivedEventHandler
{
    public function __construct(
        private  SendMessageToUsersByChannelsResolver $sendMessageToUserByChannelResolver
    )
    {
    }
    public function __invoke(MovimientoPendienteWarningDayArrived $event): void
    {
        $this->sendMessageToUserByChannelResolver->resolve($event);
    }

}
