<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Infrastructure\Notificacion\Framework\Laravel\EventHandlers;
use App\Domains\Notificacion\Events\SuscriptorVerified;
use App\Infrastructure\Notificacion\Framework\Laravel\Broadcasting\LaravelSuscriptorVerifiedBroadcast;

/**
 * Manejador del evento de verificacion del suscriptor para que el frontend pueda recibir la notificacion
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class LaravelBroadcastSuscriptorVerifiedEventHandler
{
    public function __invoke(SuscriptorVerified $event): void
    {
        $suscriptorId = $event->getSuscriptor()->getId()->getValue();
        broadcast(new LaravelSuscriptorVerifiedBroadcast($suscriptorId));
    }

}
