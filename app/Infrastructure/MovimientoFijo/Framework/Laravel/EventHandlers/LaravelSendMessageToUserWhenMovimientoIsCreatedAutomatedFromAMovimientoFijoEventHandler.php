<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Infrastructure\MovimientoFijo\Framework\Laravel\EventHandlers;

use App\Application\MovimientoFijo\Events\AutomatedMovimientoFijoProcessed;
use App\Shared\Application\Resolvers\SendMessageToUsersByChannelsResolver;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * manejador de evento para enviar un mensaje al usuario cuando un movimiento fue creado a partir de un movimiento fijo
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class LaravelSendMessageToUserWhenMovimientoIsCreatedAutomatedFromAMovimientoFijoEventHandler implements ShouldQueue
{
    public function __construct(
        private  SendMessageToUsersByChannelsResolver $sendMessageToUserByChannelResolver
    )
    {
    }
    public function __invoke( AutomatedMovimientoFijoProcessed $event): void
    {
        $this->sendMessageToUserByChannelResolver->resolve($event);
    }

}
