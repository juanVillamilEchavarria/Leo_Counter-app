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
use App\Application\Notificacion\Contracts\Builders\SendVerificationToSuscriptorFormatBuilderContract;
use App\Infrastructure\Notificacion\Framework\Laravel\Builders\LaravelSendEmailVerificationToSuscriptorFormatBuilder;
class VerificationFormatBuilderProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(SendVerificationToSuscriptorFormatBuilderContract::class, LaravelSendEmailVerificationToSuscriptorFormatBuilder::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
