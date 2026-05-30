<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
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
