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

use App\Application\MovimientoFijo\Events\AutomatedMovimientoFijoProcessed;
use App\Domains\Usuario\Aggregates\Usuario;
use App\Shared\Application\Contracts\Builders\EmailFormatBuilderContract;
use App\Shared\Application\DTOs\EmailMessageDTO;
use App\Shared\Application\Services\CompactHTMLBodyService;
use App\Shared\Domain\Contracts\EventContract;

final readonly class LaravelMovimientoCreatedAutomatedEmailFormatBuilder implements EmailFormatBuilderContract
{

    public function __construct(
        private CompactHTMLBodyService $compact
    )
    {
    }
    /**
     * @param AutomatedMovimientoFijoProcessed $event
     * @param Usuario $usuario
     * @return EmailMessageDTO
     */
    public function build(EventContract $event, Usuario $usuario): EmailMessageDTO
    {
        $body = view('movimientos_fijos.notifications.emails.movimiento_created_automated', [
            'name'=> $usuario->getName(),
            'movimientosFijos'=> $event->getMovimientosFijos()
        ])->render();
        $minifiedBody = $this->compact->compact($body);
        return new EmailMessageDTO(
            to: $usuario->getEmail(),
            subject: 'Movimientos creados automaticamente a partir de movimientos fijos',
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
        return $event instanceof AutomatedMovimientoFijoProcessed;
    }
}
