<?php

namespace App\Infrastructure\Notificacion\Framework\Laravel\EventHandlers;
use App\Application\Notificacion\Resolvers\SendVerificationToSuscriptorResolver;
use App\Domains\Notificacion\Contracts\Events\SendVerificationToSuscriptorEventContract;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Manejador del evento para el envio de verificacion de correo electronico al suscriptor
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final  class LaravelSendVerificationToSuscriptorEventHandler implements ShouldQueue
{
    public $afterCommit = true;
    public function __construct(
        private SendVerificationToSuscriptorResolver $resolver
    )
    {
    }
    public function __invoke(SendVerificationToSuscriptorEventContract $event): void
    {
         $this->resolver->resolve($event);
    }

}
