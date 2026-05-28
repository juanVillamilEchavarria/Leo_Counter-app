<?php

namespace App\Infrastructure\Auth\Framework\Laravel\Builders;

use App\Application\Auth\Contracts\Builders\PasswordResetEmailFormatBuilderContract;
use App\Domains\Auth\Events\PasswordResetLinkRequested;
use App\Domains\Usuario\Aggregates\Usuario;
use App\Shared\Application\Contracts\Builders\EmailFormatBuilderContract;
use App\Shared\Application\DTOs\EmailMessageDTO;
use App\Shared\Domain\Contracts\EventContract;
use Illuminate\Support\Facades\URL;

/**
 * Builder Laravel del correo de restablecimiento de contraseña.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Infrastructure\Auth\Framework\Laravel\Builders
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class LaravelPasswordResetEmailFormatBuilder implements EmailFormatBuilderContract
{
    /**
     * @param PasswordResetLinkRequested $event
     * @param Usuario $usuario
     * @return EmailMessageDTO
     */
    public function build(EventContract $event, Usuario $usuario): EmailMessageDTO
    {
        $svgPath = public_path('favicon.svg');
        $logoSvg = '';
        $signedUrl = URL::temporarySignedRoute(
            'password.reset',
            now()->addMinutes(60),
            [
                'email' => $usuario->getEmail()->__toString(),
                'token' => $event->getToken(),
            ]
        );

        if (file_exists($svgPath)) {
            $logoSvg = file_get_contents($svgPath);
        }

        $body = view('auth.emails.password-reset', [
            'name'=> $usuario->getName(),
            'signedUrl' => $signedUrl,
            'logoSvg' => $logoSvg,
        ]);

        return new EmailMessageDTO(
            to: $usuario->getEmail(),
            subject: 'Restablece tu contraseña',
            htmlBody: $body
        );
    }
    public function supports(EventContract $event): bool
    {
        return $event instanceof PasswordResetLinkRequested;
    }
}
