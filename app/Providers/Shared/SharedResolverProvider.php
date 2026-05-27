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
