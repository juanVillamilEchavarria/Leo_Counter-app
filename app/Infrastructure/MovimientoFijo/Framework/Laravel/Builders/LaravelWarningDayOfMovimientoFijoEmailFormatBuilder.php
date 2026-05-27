<?php

namespace App\Infrastructure\MovimientoFijo\Framework\Laravel\Builders;

use App\Domains\MovimientoFijo\Events\MovimientoFijoWarningDayArrived;
use App\Domains\Usuario\Aggregates\Usuario;
use App\Shared\Application\Contracts\Builders\EmailFormatBuilderContract;
use App\Shared\Application\DTOs\EmailMessageDTO;
use App\Shared\Domain\Contracts\EventContract;

final readonly class LaravelWarningDayOfMovimientoFijoEmailFormatBuilder implements EmailFormatBuilderContract
{

    /**
     * @param MovimientoFijoWarningDayArrived $event
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
        $body = view('movimientos.alerts.emails.warning_day', [
            'name'=> $usuario->getName(),
            'tipo'=> 'movimiento fijo',
            'logoSvg' => $logoSvg

        ]);
        return new EmailMessageDTO(
            to: $usuario->getEmail(),
            subject: 'Movimiento fijo proximo a realizarse',
            htmlBody: $body
        );

    }
}
