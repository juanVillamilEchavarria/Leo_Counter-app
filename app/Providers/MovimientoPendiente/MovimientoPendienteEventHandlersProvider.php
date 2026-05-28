<?php

namespace App\Providers\MovimientoPendiente;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Domains\MovimientoPendiente\Events\MovimientoPendienteWarningDayArrived;
use App\Domains\MovimientoPendiente\Events\MovimientoPendienteExpired;
use App\Application\MovimientoPendiente\EventHandlers\SendMessageToUsersWhenMovimientoPendienteWarningDayArrivedEventHandler;
use App\Application\MovimientoPendiente\EventHandlers\SendMessageToUsersWhenMovimientoPendienteExpiredEventHandler;

/**
 * Provider de handlers de eventos del modulo MovimientoPendiente.
 * Registra los listeners de eventos que disparan el envio de notificaciones para movimientos pendientes.
 *
 * Pequeno y especializado: solo registra los mappings entre eventos y handlers.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Providers\MovimientoPendiente
 */
final class MovimientoPendienteEventHandlersProvider extends ServiceProvider
{
    public function register(): void
    {
        // No se requieren bindings específicos: los handlers son resolvibles por el contenedor.
    }

    public function boot(): void
    {
        Event::listen(MovimientoPendienteWarningDayArrived::class, SendMessageToUsersWhenMovimientoPendienteWarningDayArrivedEventHandler::class);
        Event::listen(MovimientoPendienteExpired::class, SendMessageToUsersWhenMovimientoPendienteExpiredEventHandler::class);
    }
}
