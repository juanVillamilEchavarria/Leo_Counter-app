<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Infrastructure\Auth\Framework\Laravel\EventHandlers;

use App\Domains\Auth\Events\PasswordResetLinkRequested;
use App\Shared\Application\Strategies\SendEmailMessageToUserStrategy;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Infrastructure\Auth\Framework\Laravel\Builders\LaravelPasswordResetEmailFormatBuilder;
use App\Shared\Application\Contracts\Services\EmailServiceContract;

/**
 * Handler asincrono para enviar el correo de restablecimiento de contraseña.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Infrastructure\Auth\Framework\Laravel\EventHandlers
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class LaravelSendPasswordResetEmailEventHandler implements ShouldQueue
{
    /**
     * @param SendEmailMessageToUserStrategy $emailStrategy Estrategia directa de envio de email.
     */
    public function __construct(
       private LaravelPasswordResetEmailFormatBuilder $builder,
       private EmailServiceContract $emailServiceContract
    ) {
    }

    /**
     * Construye el correo y delega el envio sin resolver masivo ni iteracion de usuarios.
     *
     * @param PasswordResetLinkRequested $event Evento de solicitud de enlace.
     * @return void
     */
    public function __invoke(PasswordResetLinkRequested $event): void
    {
        $emailMessageDTO= $this->builder->build($event, $event->getUsuario());
        $this->emailServiceContract->sendEmail($emailMessageDTO);

    }
}
