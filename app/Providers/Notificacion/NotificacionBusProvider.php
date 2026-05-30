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

use App\Shared\Infrastructure\Framework\Laravel\Middlewares\LaravelTransactionMiddleware;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Bus;

use App\Application\Notificacion\Commands\ToggleCanalCommand;
use App\Application\Notificacion\Commands\StoreSuscriptorCommand;
use App\Application\Notificacion\Commands\DestroySuscriptorCommand;
use App\Application\Notificacion\Commands\ToggleSuscriptorCommand;
use App\Application\Notificacion\Commands\VerifySuscriptorCommand;

use App\Application\Notificacion\Commands\Handlers\ToggleCanalHandler;
use App\Application\Notificacion\Commands\Handlers\StoreSuscriptorHandler;
use App\Application\Notificacion\Commands\Handlers\DestroySuscriptorHandler;
use App\Application\Notificacion\Commands\Handlers\ToggleSuscriptorHandler;
use App\Application\Notificacion\Commands\Handlers\VerifySuscriptorHandler;

class NotificacionBusProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Bus::map([
            ToggleCanalCommand::class => ToggleCanalHandler::class,
            StoreSuscriptorCommand::class => StoreSuscriptorHandler::class,
            DestroySuscriptorCommand::class => DestroySuscriptorHandler::class,
            ToggleSuscriptorCommand::class => ToggleSuscriptorHandler::class,
            VerifySuscriptorCommand::class => VerifySuscriptorHandler::class,
        ]);
    }
}
