<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Notificacion\Events;

use App\Domains\Notificacion\Aggregates\Suscriptor;
use App\Domains\Notificacion\Contracts\Events\SendVerificationToSuscriptorEventContract;
use App\Domains\Usuario\Aggregates\Usuario;
use App\Shared\Domain\ValueObjects\Date;

/**
 * Evento de creación de suscriptor de notificación
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class SuscriptorCreated implements SendVerificationToSuscriptorEventContract
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
        return true;
    }

    public function getUsuario(): Usuario
    {
        return $this->usuario;
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
