<?php

namespace App\Providers\Usuario;

use App\Application\Usuario\Commands\ChangePasswordCommand;
use App\Application\Usuario\Commands\Handlers\ChangePasswordHandler;
use App\Application\Usuario\Commands\Handlers\UpdatePublicDataHandler;
use App\Application\Usuario\Commands\UpdatePublicDataCommand;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\ServiceProvider;

/**
 * Service provider del mapeo de comandos del módulo Usuario.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Providers\Usuario
 * @since 1.0.0
 * @version 1.0.0
 */
final class UsuarioBusProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        Bus::map([
            UpdatePublicDataCommand::class => UpdatePublicDataHandler::class,
            ChangePasswordCommand::class => ChangePasswordHandler::class,
        ]);
    }
}
