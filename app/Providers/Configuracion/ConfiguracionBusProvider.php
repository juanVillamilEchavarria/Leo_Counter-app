<?php

namespace App\Providers\Configuracion;

use App\Application\Configuracion\Commands\Handlers\HardDeleteRecordHandler;
use App\Application\Configuracion\Commands\Handlers\RestoreRecordHandler;
use App\Application\Configuracion\Commands\HardDeleteRecordCommand;
use App\Application\Configuracion\Commands\RestoreRecordCommand;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\ServiceProvider;

/**
 * Service provider para el mapeo de comandos del módulo Configuración.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Providers\Configuracion
 * @since 1.0.0
 * @version 1.0.0
 */
final class ConfiguracionBusProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        Bus::map([
            RestoreRecordCommand::class => RestoreRecordHandler::class,
            HardDeleteRecordCommand::class => HardDeleteRecordHandler::class,
        ]);
    }
}
