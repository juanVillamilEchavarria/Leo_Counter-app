<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Domains\Auth\Events;

use App\Domains\Usuario\Aggregates\Usuario;
use App\Domains\Usuario\Contracts\Repositories\UsuarioRepositoryContract;
use App\Shared\Domain\Contracts\EventContract;
use App\Shared\Domain\ValueObjects\Date;

/**
 * Evento de dominio emitido cuando se solicita un enlace de restablecimiento de contraseña.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Auth\Events
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class PasswordResetLinkRequested implements EventContract
{
    /**
     * @param Usuario $usuario Correo electronico del usuario.
     * @param Date $ocurredOn Fecha en la que ocurrio el evento.
     */
    public function __construct(
        private Usuario $usuario,
        private string $token,
        private Date $ocurredOn = new Date(new \DateTimeImmutable())
    ) {
    }
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * Retorna el correo electronico del usuario.
     *
     * @return Usuario
     */
    public function getUsuario(): Usuario
    {
        return $this->usuario;
    }


    /**
     * @inheritDoc
     */
    public function ocurredOn(): Date
    {
        return $this->ocurredOn;
    }
}
