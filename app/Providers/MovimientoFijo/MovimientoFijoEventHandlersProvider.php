<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Providers\MovimientoFijo;

use App\Application\MovimientoFijo\Events\AutomatedMovimientoFijoProcessed;
use App\Application\MovimientoFijo\Events\MovimientoFijoWarningDayArrived;
use App\Application\MovimientoPendiente\Events\MovimientoPendienteCreatedFromMovimientoFijo;
use App\Infrastructure\MovimientoFijo\Framework\Laravel\EventHandlers\LaravelSendMessageToUserWhenMovimientoFijoWarningDayArrivedEventHandler;
use App\Infrastructure\MovimientoFijo\Framework\Laravel\EventHandlers\LaravelSendMessageToUserWhenMovimientoIsCreatedAutomatedFromAMovimientoFijoEventHandler;
use App\Infrastructure\MovimientoFijo\Framework\Laravel\EventHandlers\LaravelSendMessageToUserWhenMovimientoPendienteIsCreatedFromAMovimientoFijoEventHandler;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

/**
 * Provider de handlers de eventos del modulo MovimientoFijo.
 * Registra listeners y configura builders para los handlers que envian mensajes cuando ocurren eventos de MovimientoFijo.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Providers\MovimientoFijo
 */
class MovimientoFijoEventHandlersProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Bindings removed: builders are now resolved via tagged services in SharedResolverProvider
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Event::listen(MovimientoFijoWarningDayArrived::class, LaravelSendMessageToUserWhenMovimientoFijoWarningDayArrivedEventHandler::class);
        Event::listen(AutomatedMovimientoFijoProcessed::class, LaravelSendMessageToUserWhenMovimientoIsCreatedAutomatedFromAMovimientoFijoEventHandler::class);
        Event::listen(MovimientoPendienteCreatedFromMovimientoFijo::class, LaravelSendMessageToUserWhenMovimientoPendienteIsCreatedFromAMovimientoFijoEventHandler::class);
    }
}
