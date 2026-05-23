<?php

namespace App\Providers\Notificacion;

use Illuminate\Support\ServiceProvider;
use App\Application\Notificacion\Resolvers\SendVerificationToSuscriptorResolver;
use App\Application\Notificacion\Strategies\SendEmailVerificationToSuscriptorStrategy;
class SendVerificationStrategyProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(SendVerificationToSuscriptorResolver::class, function () {
            return new SendVerificationToSuscriptorResolver(
                [
                    $this->app->make(SendEmailVerificationToSuscriptorStrategy::class)
                ]
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
