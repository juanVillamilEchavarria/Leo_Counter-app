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
use Illuminate\Support\Facades\View;
use function Termwind\render;

/**
 * Constructor de la notificacion de verificacion de correo electronico al suscriptor
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class LaravelSendEmailVerificationToSuscriptorFormatBuilder implements SendVerificationToSuscriptorFormatBuilderContract
{

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
        $svgPath = public_path('favicon.svg');
        $logoSvg = '';
        if (file_exists($svgPath)) {
            $logoSvg = file_get_contents($svgPath);
        }
        $body = view('notificaciones.suscriptores.email.verify', [
            'name'=> $event->getUsuario()->getName(),
            'signedUrl'=> $signedUrl,
            'logoSvg' => $logoSvg

        ]);

        $emailMessage= new EmailMessageDTO(
            to: $event->getUsuario()->getEmail(),
            subject: 'Verificacion de correo electronico para recibir notificaciones por email',
            htmlBody: $body
        );
        \Log::info('EmailMessageDTO creado para verificación', [
            'to' => $emailMessage->to->__toString(),
            'subject' => $emailMessage->subject,
        ]);
        return $emailMessage;

    }
}
