<?php

namespace App\Infrastructure\MovimientoPendiente\Framework\Laravel\Builders;

use App\Domains\MovimientoPendiente\Events\MovimientoPendienteExpired;
use App\Domains\Usuario\Aggregates\Usuario;
use App\Shared\Application\Contracts\Builders\EmailFormatBuilderContract;
use App\Shared\Application\DTOs\EmailMessageDTO;
use App\Shared\Domain\Contracts\EventContract;

final readonly class LaravelMovimientoPendienteExpiredEmailFormatBuilder implements EmailFormatBuilderContract
{

    /**
     * @param MovimientoPendienteExpired $event
     * @param Usuario $usuario
     * @return EmailMessageDTO
     */
    public function build(EventContract $event, Usuario $usuario): EmailMessageDTO
    {
        $svgPath = public_path('favicon.svg');
        $logoSvg = '';
        if (file_exists($svgPath)) {
            $logoSvg = file_get_contents($svgPath);
        }
        $body = view('movimientos_pendientes.emails.expired', [
            'name'=> $usuario->getName(),
            'movimiento'=> $event->getMovimientoPendiente(),
            'logoSvg' => $logoSvg
        ]);
        return new EmailMessageDTO(
            to: $usuario->getEmail(),
            subject: 'Movimiento Pendiente Vencido',
            htmlBody: $body
        );
    }
}
