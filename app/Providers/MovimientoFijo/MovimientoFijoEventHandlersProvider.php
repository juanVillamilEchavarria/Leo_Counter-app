<?php

namespace App\Providers\MovimientoFijo;

use Illuminate\Support\ServiceProvider;
use App\Application\MovimientoFijo\EventHandlers\SendMessageToUserWhenMovimientoFijoWarningDayArrivedEventHandler;
use App\Application\MovimientoFijo\EventHandlers\SendMessageToUserWhenMovimientoPendienteIsCreatedFromAMovimientoFijoEventHandler;
use App\Application\MovimientoFijo\EventHandlers\SendMessageToUserWhenMovimientoIsCreatedAutomatedFromAMovimientoFijoEventHandler;
use App\Shared\Application\Contracts\Builders\EmailFormatBuilderContract;
use App\Infrastructure\MovimientoFijo\Framework\Laravel\Builders\LaravelWarningDayOfMovimientoFijoEmailFormatBuilder;
use App\Infrastructure\MovimientoFijo\Framework\Laravel\Builders\LaravelMovimientoCreatedAutomatedEmailFormatBuilder;
use App\Infrastructure\MovimientoFijo\Framework\Laravel\Builders\LaravelMovimientoPendienteCreatedFromAMovimientoFijoEmailFormatBuilder;


class MovimientoFijoEventHandlersProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->when(SendMessageToUserWhenMovimientoFijoWarningDayArrivedEventHandler::class)
            ->needs(EmailFormatBuilderContract::class)
            ->give(LaravelWarningDayOfMovimientoFijoEmailFormatBuilder::class);
        $this->app->when(SendMessageToUserWhenMovimientoIsCreatedAutomatedFromAMovimientoFijoEventHandler::class)
            ->needs(EmailFormatBuilderContract::class)
            ->give(LaravelMovimientoCreatedAutomatedEmailFormatBuilder::class);
        $this->app->when(SendMessageToUserWhenMovimientoPendienteIsCreatedFromAMovimientoFijoEventHandler::class)
            ->needs(EmailFormatBuilderContract::class)
            ->give(LaravelMovimientoPendienteCreatedFromAMovimientoFijoEmailFormatBuilder::class);

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
