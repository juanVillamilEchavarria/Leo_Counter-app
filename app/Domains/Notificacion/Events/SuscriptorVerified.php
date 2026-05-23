<?php

namespace App\Domains\Notificacion\Events;

use App\Domains\Notificacion\Aggregates\Suscriptor;
use App\Domains\Notificacion\Contracts\Events\SendVerificationToSuscriptorEventContract;
use App\Shared\Domain\Contracts\EventContract;
use App\Shared\Domain\ValueObjects\Date;

/**
 * Evento de verificacion de suscriptor
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class SuscriptorVerified implements EventContract
{
    public function __construct(
       private  Suscriptor $suscriptor,
        private Date       $date
    )
    {
    }

    public function getSuscriptor(): Suscriptor
    {
        return $this->suscriptor;
    }
    /**
     * @inheritDoc
     */
    public function ocurredOn(): Date
    {
       return $this->date;
    }
}
