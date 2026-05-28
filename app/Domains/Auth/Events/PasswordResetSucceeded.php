<?php

namespace App\Domains\Auth\Events;

use App\Shared\Domain\Contracts\EventContract;
use App\Shared\Domain\ValueObjects\Date;

/**
 * Evento de dominio emitido cuando una contraseña se restablece correctamente.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Auth\Events
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class PasswordResetSucceeded implements EventContract
{
    /**
     * @param string $email Correo electronico del usuario restablecido.
     * @param Date $ocurredOn Fecha en la que ocurrio el evento.
     */
    public function __construct(
        private string $email,
        private Date $ocurredOn = new Date(new \DateTimeImmutable())
    ) {
    }

    /**
     * Retorna el correo electronico del usuario.
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @inheritDoc
     */
    public function ocurredOn(): Date
    {
        return $this->ocurredOn;
    }
}
