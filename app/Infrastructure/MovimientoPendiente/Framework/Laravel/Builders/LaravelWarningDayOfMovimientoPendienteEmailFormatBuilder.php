<?php

namespace App\Infrastructure\MovimientoPendiente\Framework\Laravel\Builders;

use App\Domains\MovimientoPendiente\Events\MovimientoPendienteWarningDayArrived;
use App\Domains\Usuario\Aggregates\Usuario;
use App\Shared\Application\Contracts\Builders\EmailFormatBuilderContract;
use App\Shared\Application\DTOs\EmailMessageDTO;
use App\Shared\Domain\Contracts\EventContract;

final readonly class LaravelWarningDayOfMovimientoPendienteEmailFormatBuilder implements EmailFormatBuilderContract
{

    /**
     * @param MovimientoPendienteWarningDayArrived $event
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
            'tipo'=> 'movimiento_pendiente',
            'movimiento'=> $event->getMovimientoPendiente(),
            'logoSvg' => $logoSvg

        ]);
        return new EmailMessageDTO(
            to: $usuario->getEmail(),
            subject: 'Movimiento Pendiente proximo a realizarse',
            htmlBody: $body
        );
    }

    /**
     * Indica si este builder soporta el evento proporcionado.
     *
     * @param EventContract $event
     * @return bool
     */
    public function supports(EventContract $event): bool
    {
        return $event instanceof MovimientoPendienteWarningDayArrived;
    }
}
