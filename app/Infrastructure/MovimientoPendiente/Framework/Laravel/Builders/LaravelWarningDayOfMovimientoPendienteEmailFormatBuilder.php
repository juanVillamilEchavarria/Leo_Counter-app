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

use App\Application\MovimientoPendiente\Events\MovimientoPendienteWarningDayArrived;
use App\Domains\Usuario\Aggregates\Usuario;
use App\Shared\Application\Contracts\Builders\EmailFormatBuilderContract;
use App\Shared\Application\DTOs\EmailMessageDTO;
use App\Shared\Application\Services\CompactHTMLBodyService;
use App\Shared\Domain\Contracts\EventContract;

final readonly class LaravelWarningDayOfMovimientoPendienteEmailFormatBuilder implements EmailFormatBuilderContract
{
    public function __construct(
        private CompactHTMLBodyService $compact
    )
    {
    }

    /**
     * @param MovimientoPendienteWarningDayArrived $event
     * @param Usuario $usuario
     * @return EmailMessageDTO
     */
    public function build(EventContract $event, Usuario $usuario): EmailMessageDTO
    {
        $body = view('movimientos.alerts.emails.warning_day', [
            'name'=> $usuario->getName(),
            'tipo'=> 'movimiento_pendiente',
            'movimiento'=> $event->getMovimientoPendiente()

        ])->render();
        $minifiedBody = $this->compact->compact($body);
        return new EmailMessageDTO(
            to: $usuario->getEmail(),
            subject: 'Movimiento Pendiente proximo a realizarse',
            htmlBody: $minifiedBody
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
