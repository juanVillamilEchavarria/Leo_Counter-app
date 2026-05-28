<?php

namespace App\Providers\MovimientoPendiente;

use App\Infrastructure\MovimientoFijo\Framework\Laravel\Builders\LaravelMovimientoPendienteCreatedFromAMovimientoFijoEmailFormatBuilder;
use App\Infrastructure\MovimientoFijo\Framework\Laravel\EventHandlers\LaravelSendMessageToUserWhenMovimientoPendienteIsCreatedFromAMovimientoFijoEventHandler;
use App\Shared\Application\Contracts\Builders\EmailFormatBuilderContract;
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
        // Bindings removed: builders are now resolved via tagged services in SharedResolverProvider
    }

    public function boot(): void
    {
        Event::listen(MovimientoPendienteWarningDayArrived::class, SendMessageToUsersWhenMovimientoPendienteWarningDayArrivedEventHandler::class);
        Event::listen(MovimientoPendienteExpired::class, SendMessageToUsersWhenMovimientoPendienteExpiredEventHandler::class);
    }
}
