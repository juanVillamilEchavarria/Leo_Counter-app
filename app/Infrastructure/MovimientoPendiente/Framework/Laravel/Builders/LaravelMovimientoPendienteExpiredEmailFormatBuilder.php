<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Infrastructure\MovimientoPendiente\Framework\Laravel\Builders;

use App\Application\MovimientoPendiente\Events\MovimientoPendienteExpired;
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

    /**
     * Indica si este builder soporta el evento proporcionado.
     *
     * @param EventContract $event
     * @return bool
     */
    public function supports(EventContract $event): bool
    {
        return $event instanceof MovimientoPendienteExpired;
    }
}
