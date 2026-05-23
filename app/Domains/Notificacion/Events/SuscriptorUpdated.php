<?php

namespace App\Domains\Notificacion\Events;

use App\Domains\Notificacion\Aggregates\Suscriptor;
use App\Domains\Notificacion\Contracts\Events\SendVerificationToSuscriptorEventContract;
use App\Domains\Usuario\Aggregates\Usuario;
use App\Shared\Domain\ValueObjects\Date;

class SuscriptorUpdated implements SendVerificationToSuscriptorEventContract
{
    public function __construct(
        private Suscriptor $suscriptor,
        private Usuario    $usuario,
        private Date       $date
    )
    {
    }
    public function needsVerification(): bool
    {
        return $this->oldSuscriptor->getVerifiedAt() === null;
    }

    /**
     * @inheritDoc
     */
    public function ocurredOn(): Date
    {
        // TODO: Implement ocurredOn() method.
    }

    public function getSuscriptor(): Suscriptor
    {
        // TODO: Implement getSuscriptor() method.
    }

    public function getUsuario(): Usuario
    {
        // TODO: Implement getUsuario() method.
    }
}
