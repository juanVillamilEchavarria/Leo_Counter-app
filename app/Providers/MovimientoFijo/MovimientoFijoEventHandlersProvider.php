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

use App\Infrastructure\MovimientoFijo\Framework\Laravel\Builders\LaravelMovimientoCreatedAutomatedEmailFormatBuilder;
use App\Infrastructure\MovimientoFijo\Framework\Laravel\Builders\LaravelMovimientoPendienteCreatedFromAMovimientoFijoEmailFormatBuilder;
use App\Infrastructure\MovimientoFijo\Framework\Laravel\Builders\LaravelWarningDayOfMovimientoFijoEmailFormatBuilder;
use App\Infrastructure\MovimientoFijo\Framework\Laravel\EventHandlers\LaravelSendMessageToUserWhenMovimientoFijoWarningDayArrivedEventHandler;
use App\Infrastructure\MovimientoFijo\Framework\Laravel\EventHandlers\LaravelSendMessageToUserWhenMovimientoIsCreatedAutomatedFromAMovimientoFijoEventHandler;
use App\Infrastructure\MovimientoFijo\Framework\Laravel\EventHandlers\LaravelSendMessageToUserWhenMovimientoPendienteIsCreatedFromAMovimientoFijoEventHandler;
use App\Shared\Application\Contracts\Builders\EmailFormatBuilderContract;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Domains\MovimientoFijo\Events\MovimientoFijoWarningDayArrived;
use App\Domains\MovimientoFijo\Events\AutomatedMovimientoFijoProcessed;
use App\Domains\MovimientoPendiente\Events\MovimientoPendienteCreatedFromMovimientoFijo;

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
