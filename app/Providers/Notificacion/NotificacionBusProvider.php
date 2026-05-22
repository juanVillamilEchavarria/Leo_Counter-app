<?php

namespace App\Providers\Notificacion;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Bus;

use App\Application\Notificacion\Commands\ToggleCanalNotificacionCommand;
use App\Application\Notificacion\Commands\StoreSuscriptorNotificacionCommand;
use App\Application\Notificacion\Commands\UpdateSuscriptorNotificacionCommand;
use App\Application\Notificacion\Commands\DestroySuscriptorNotificacionCommand;
use App\Application\Notificacion\Commands\ToggleSuscriptorNotificacionCommand;

use App\Application\Notificacion\Commands\Handlers\ToggleCanalNotificacionHandler;
use App\Application\Notificacion\Commands\Handlers\StoreSuscriptorNotificacionHandler;
use App\Application\Notificacion\Commands\Handlers\UpdateSuscriptorNotificacionHandler;
use App\Application\Notificacion\Commands\Handlers\DestroySuscriptorNotificacionHandler;
use App\Application\Notificacion\Commands\Handlers\ToggleSuscriptorNotificacionHandler;

class NotificacionBusProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Bus::map([
            ToggleCanalNotificacionCommand::class => ToggleCanalNotificacionHandler::class,
            StoreSuscriptorNotificacionCommand::class => StoreSuscriptorNotificacionHandler::class,
            UpdateSuscriptorNotificacionCommand::class => UpdateSuscriptorNotificacionHandler::class,
            DestroySuscriptorNotificacionCommand::class => DestroySuscriptorNotificacionHandler::class,
            ToggleSuscriptorNotificacionCommand::class => ToggleSuscriptorNotificacionHandler::class,
        ]);
    }
}
