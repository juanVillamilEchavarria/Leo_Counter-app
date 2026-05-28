<?php

namespace App\Providers\Shared;

use App\Infrastructure\Auth\Framework\Laravel\Builders\LaravelPasswordResetEmailFormatBuilder;
use Illuminate\Support\ServiceProvider;
use App\Shared\Application\Resolvers\SendMessageToUsersByChannelsResolver;
use App\Shared\Application\Strategies\SendEmailMessageToUserStrategy;
use App\Infrastructure\Usuario\Queries\Executors\Eloquent\EloquentGetUsersWhoCanBeNotifiedQueryExecutor;

class SharedResolverProvider extends ServiceProvider
{
    public function register(): void
    {
        // Tag all email format builders
        $this->app->tag([
            \App\Infrastructure\MovimientoFijo\Framework\Laravel\Builders\LaravelWarningDayOfMovimientoFijoEmailFormatBuilder::class,
            \App\Infrastructure\MovimientoFijo\Framework\Laravel\Builders\LaravelMovimientoCreatedAutomatedEmailFormatBuilder::class,
            \App\Infrastructure\MovimientoFijo\Framework\Laravel\Builders\LaravelMovimientoPendienteCreatedFromAMovimientoFijoEmailFormatBuilder::class,
            \App\Infrastructure\MovimientoPendiente\Framework\Laravel\Builders\LaravelWarningDayOfMovimientoPendienteEmailFormatBuilder::class,
            \App\Infrastructure\MovimientoPendiente\Framework\Laravel\Builders\LaravelMovimientoPendienteExpiredEmailFormatBuilder::class,
            LaravelPasswordResetEmailFormatBuilder::class
        ], 'email.format.builders');

        $this->app->when(SendEmailMessageToUserStrategy::class)
            ->needs('$emailFormatBuilders')
            ->giveTagged('email.format.builders');

        // Tag notification channel strategies
        $this->app->tag([
            SendEmailMessageToUserStrategy::class,
            // Futuras estrategias (SMS, WhatsApp) se añadirán aquí
        ], 'notification.channel.strategies');

        // El resolver recibe las estrategias etiquetadas
        $this->app->singleton(SendMessageToUsersByChannelsResolver::class, function ($app) {
            return new SendMessageToUsersByChannelsResolver(
                strategies: $app->tagged('notification.channel.strategies'),
                getUsersWhoCanBeNotifiedQueryExecutor: $app->make(EloquentGetUsersWhoCanBeNotifiedQueryExecutor::class)
            );
        });
    }

    public function boot(): void {}
}
