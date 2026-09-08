<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */

namespace App\Providers\Shared;

use App\Infrastructure\Auth\Framework\Laravel\Builders\LaravelPasswordResetEmailFormatBuilder;
use App\Shared\Application\Strategies\SendEmailMessageToUserStrategy;
use Illuminate\Support\ServiceProvider;

class EmailFormatBuildersProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->tag([
            \App\Infrastructure\MovimientoFijo\Framework\Laravel\Builders\LaravelWarningDayOfMovimientoFijoEmailFormatBuilder::class,
            \App\Infrastructure\MovimientoFijo\Framework\Laravel\Builders\LaravelMovimientoCreatedAutomatedEmailFormatBuilder::class,
            \App\Infrastructure\MovimientoFijo\Framework\Laravel\Builders\LaravelMovimientoPendienteCreatedFromAMovimientoFijoEmailFormatBuilder::class,
            \App\Infrastructure\MovimientoPendiente\Framework\Laravel\Builders\LaravelWarningDayOfMovimientoPendienteEmailFormatBuilder::class,
            \App\Infrastructure\MovimientoPendiente\Framework\Laravel\Builders\LaravelMovimientoPendienteExpiredEmailFormatBuilder::class,
            LaravelPasswordResetEmailFormatBuilder::class,
            \App\Infrastructure\Exportacion\Framework\Laravel\Builders\LaravelTooManyRecordsExportedEmailFormatBuilder::class,
        ], 'email.format.builders');

        $this->app->when(SendEmailMessageToUserStrategy::class)
            ->needs('$emailFormatBuilders')
            ->giveTagged('email.format.builders');
    }

    public function boot(): void {}
}
