<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Providers\Propietario;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Bus;
use App\Application\Propietario\Commands\StorePropietarioCommand;
use App\Application\Propietario\Commands\UpdatePropietarioCommand;
use App\Application\Propietario\Commands\DestroyPropietarioCommand;
use App\Application\Propietario\Commands\Handlers\StorePropietarioHandler;
use App\Application\Propietario\Commands\Handlers\UpdatePropietarioHandler;
use App\Application\Propietario\Commands\Handlers\DestroyPropietarioHandler;

class PropietarioBusProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        Bus::map([
            StorePropietarioCommand::class => StorePropietarioHandler::class,
            UpdatePropietarioCommand::class => UpdatePropietarioHandler::class,
            DestroyPropietarioCommand::class => DestroyPropietarioHandler::class,
        ]);
    }
}
