<?php

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
