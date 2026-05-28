<?php

namespace App\Providers\Shared;

use Illuminate\Support\ServiceProvider;
use App\Shared\Application\Resolvers\SendMessageToUsersByChannelsResolver;
use App\Shared\Application\Strategies\SendEmailMessageToUserStrategy;
use App\Infrastructure\Usuario\Queries\Executors\Eloquent\EloquentGetUsersWhoCanBeNotifiedQueryExecutor;

class SharedResolverProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Tag all email format builders so they can be injected as an iterable into the email strategy
        $this->app->tag([
            \App\Infrastructure\MovimientoFijo\Framework\Laravel\Builders\LaravelWarningDayOfMovimientoFijoEmailFormatBuilder::class,
            \App\Infrastructure\MovimientoFijo\Framework\Laravel\Builders\LaravelMovimientoCreatedAutomatedEmailFormatBuilder::class,
            \App\Infrastructure\MovimientoFijo\Framework\Laravel\Builders\LaravelMovimientoPendienteCreatedFromAMovimientoFijoEmailFormatBuilder::class,
            \App\Infrastructure\MovimientoPendiente\Framework\Laravel\Builders\LaravelWarningDayOfMovimientoPendienteEmailFormatBuilder::class,
            \App\Infrastructure\MovimientoPendiente\Framework\Laravel\Builders\LaravelMovimientoPendienteExpiredEmailFormatBuilder::class,
        ], 'email.format.builders');

        // When resolving the SendEmailMessageToUserStrategy, inject the tagged builders into the $emailFormatBuilders constructor parameter
        $this->app->when(SendEmailMessageToUserStrategy::class)
            ->needs('$emailFormatBuilders')
            ->giveTagged('email.format.builders');

        $this->app->singleton(SendMessageToUsersByChannelsResolver::class, function ($app) {
            return new SendMessageToUsersByChannelsResolver(
                strategies: [
                    app(SendEmailMessageToUserStrategy::class)
                ],
                getUsersWhoCanBeNotifiedQueryExecutor: app(EloquentGetUsersWhoCanBeNotifiedQueryExecutor::class)
            );
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
