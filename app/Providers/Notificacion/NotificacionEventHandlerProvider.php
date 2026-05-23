<?php

namespace App\Providers\Notificacion;

use Illuminate\Support\ServiceProvider;
use App\Domains\Notificacion\Events\SuscriptorVerified;
use App\Infrastructure\Notificacion\Framework\Laravel\EventHandlers\LaravelBroadcastSuscriptorVerifiedEventHandler;
use Illuminate\Support\Facades\Event;
use App\Domains\Notificacion\Events\SuscriptorCreated;
use App\Infrastructure\Notificacion\Framework\Laravel\EventHandlers\LaravelSendVerificationToSuscriptorEventHandler;
class NotificacionEventHandlerProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Event::listen(SuscriptorVerified::class, LaravelBroadcastSuscriptorVerifiedEventHandler::class);
        Event::listen(SuscriptorCreated::class, LaravelSendVerificationToSuscriptorEventHandler::class);
        //
    }
}
