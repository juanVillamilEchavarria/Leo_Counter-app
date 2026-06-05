<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Infrastructure\Notificacion\Framework\Laravel\Builders;

use App\Application\Notificacion\Contracts\Builders\SendVerificationToSuscriptorFormatBuilderContract;
use App\Domains\Notificacion\Contracts\Events\SendVerificationToSuscriptorEventContract;
use App\Shared\Application\DTOs\EmailMessageDTO;
use App\Shared\Application\Services\CompactHTMLBodyService;

/**
 * Constructor de la notificacion de verificacion de correo electronico al suscriptor
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class LaravelSendEmailVerificationToSuscriptorFormatBuilder implements SendVerificationToSuscriptorFormatBuilderContract
{
    public function __construct(
        private CompactHTMLBodyService $compact
    )
    {
    }

    /**
     * @inheritDoc
     */
    public function create(SendVerificationToSuscriptorEventContract $event): EmailMessageDTO
    {
        $signedUrl = \Illuminate\Support\Facades\URL::temporarySignedRoute(
            'configuracion.notificaciones.suscriptores.verify',
            now()->addHours(24),
            ['suscriptorId'=>  $event->getSuscriptor()->getId()->getValue()]
        );
        $body = view('notificaciones.suscriptores.email.verify', [
            'name'=> $event->getUsuario()->getName(),
            'signedUrl'=> $signedUrl

        ])->render();
        $minifiedBody = $this->compact->compact($body);

        $emailMessage= new EmailMessageDTO(
            to: $event->getUsuario()->getEmail(),
            subject: 'Verificacion de correo electronico para recibir notificaciones por email',
            htmlBody: $minifiedBody
        );
        return $emailMessage;

    }
}
