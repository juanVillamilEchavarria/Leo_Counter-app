<?php

namespace App\Infrastructure\Notificacion\Framework\Laravel\Broadcasting;

use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Broadcasting\PrivateChannel;

/**
 * Broadcast para el evento de verificacion del suscriptor
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class LaravelSuscriptorVerifiedBroadcast implements ShouldBroadcast
{

    public function __construct(
        public string $suscriptorId
    ) {}

    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('suscriptor.' . $this->suscriptorId);
    }

    public function broadcastAs(): string
    {
        return 'SuscriptorVerified';
    }
}
