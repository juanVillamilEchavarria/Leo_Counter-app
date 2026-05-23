<?php

namespace App\Application\Notificacion\Resolvers;

use App\Application\Notificacion\Contracts\Strategies\SendVerificationToSuscriptorStrategyContract;
use App\Domains\Notificacion\Contracts\Events\SendVerificationToSuscriptorEventContract;
use App\Domains\Notificacion\Events\SuscriptorCreated;

/**
 * Resuelve la estrategia para el envio de verificacion de correo electronico al suscriptor
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class SendVerificationToSuscriptorResolver
{
    /**
     * @param iterable<SendVerificationToSuscriptorStrategyContract> $strategies
     */
    public function __construct(
        private iterable $strategies
    )
    {
    }

    public function resolve(SendVerificationToSuscriptorEventContract $event): void{
        foreach($this->strategies as $strategy){
            if($strategy->supports($event)){
                $strategy->sendVerification($event);
                return;
            }
        }
    }

}
