<?php

namespace App\Providers\Usuario;

use App\Application\Usuario\Commands\ChangeUserPasswordCommand;
use App\Application\Usuario\Commands\ChangeOwnPasswordCommand;
use App\Application\Usuario\Commands\CreateTheAdminUserCommand;
use App\Application\Usuario\Commands\DestroyUsuarioCommand;
use App\Application\Usuario\Commands\Handlers\ChangeUserPasswordHandler;
use App\Application\Usuario\Commands\Handlers\ChangeOwnPasswordHandler;
use App\Application\Usuario\Commands\Handlers\CreateTheAdminUserHandler;
use App\Application\Usuario\Commands\Handlers\DestroyUsuarioHandler;
use App\Application\Usuario\Commands\Handlers\StoreUsuarioHandler;
use App\Application\Usuario\Commands\Handlers\UpdatePublicDataHandler;
use App\Application\Usuario\Commands\StoreUsuarioCommand;
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
            StoreUsuarioCommand::class => StoreUsuarioHandler::class,
            UpdatePublicDataCommand::class => UpdatePublicDataHandler::class,
            ChangeOwnPasswordCommand::class => ChangeOwnPasswordHandler::class,
            ChangeUserPasswordCommand::class => ChangeUserPasswordHandler::class,
            DestroyUsuarioCommand::class => DestroyUsuarioHandler::class,
            CreateTheAdminUserCommand::class => CreateTheAdminUserHandler::class
        ]);
    }
}
