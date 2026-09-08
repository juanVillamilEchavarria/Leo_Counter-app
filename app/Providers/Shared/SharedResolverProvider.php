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
use Illuminate\Support\ServiceProvider;
use App\Shared\Application\Resolvers\SendMessageToUsersByChannelsResolver;
use App\Shared\Application\Strategies\SendEmailMessageToUserStrategy;
use App\Infrastructure\Usuario\Queries\Executors\Eloquent\EloquentGetUsersWhoCanBeNotifiedQueryExecutor;

class SharedResolverProvider extends ServiceProvider
{
    public function register(): void
    {

        
        $this->app->tag([
            SendEmailMessageToUserStrategy::class,
            
        ], 'notification.channel.strategies');


        $this->app->singleton(SendMessageToUsersByChannelsResolver::class, function ($app) {
            return new SendMessageToUsersByChannelsResolver(
                strategies: $app->tagged('notification.channel.strategies'),
                getUsersWhoCanBeNotifiedQueryExecutor: $app->make(EloquentGetUsersWhoCanBeNotifiedQueryExecutor::class)
            );
        });
    }

    public function boot(): void {}
}
