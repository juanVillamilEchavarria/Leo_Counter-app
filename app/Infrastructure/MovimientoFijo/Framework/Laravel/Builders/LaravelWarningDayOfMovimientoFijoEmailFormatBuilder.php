<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Infrastructure\MovimientoFijo\Framework\Laravel\Builders;

use App\Application\MovimientoFijo\Events\MovimientoFijoWarningDayArrived;
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
            'movimiento'=> $event->getMovimientoFijo(),
            'logoSvg' => $logoSvg

        ]);
        return new EmailMessageDTO(
            to: $usuario->getEmail(),
            subject: 'Movimiento fijo proximo a realizarse',
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
        return $event instanceof MovimientoFijoWarningDayArrived;
    }
}
