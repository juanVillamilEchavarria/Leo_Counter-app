<?php

namespace App\Domains\Notificacion\Contracts\Events;

use App\Domains\Notificacion\Aggregates\Suscriptor;
use App\Shared\Domain\Contracts\EventContract;
use App\Domains\Usuario\Aggregates\Usuario;

/**
 * Contrato que debe implementar todos los eventos que envian una verificacion al suscriptor.
 * Como ejemplo pueden ser suscriptor creado o suscriptor actualizado.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
interface SendVerificationToSuscriptorEventContract extends EventContract
{
    /**
     * Indica si el suscriptor necesita una verificación.
     * @return bool
     */
    public function needsVerification(): bool;
    public function getSuscriptor(): Suscriptor;
    public function getUsuario(): Usuario;

}
