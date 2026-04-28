<?php

namespace App\Providers\Cuenta;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Bus;
use App\Application\Cuenta\Commands\StoreCuentaCommand;
use App\Application\Cuenta\Commands\UpdateCuentaCommand;
use App\Application\Cuenta\Commands\DestroyCuentaCommand;
use App\Application\Cuenta\Commands\ToggleCuentaCommand;
use App\Application\Cuenta\Commands\Handlers\StoreCuentaHandler;
use App\Application\Cuenta\Commands\Handlers\UpdateCuentaHandler;
use App\Application\Cuenta\Commands\Handlers\DestroyCuentaHandler;
use App\Application\Cuenta\Commands\Handlers\ToggleCuentaHandler;

class CuentaBusProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        Bus::map([
            StoreCuentaCommand::class => StoreCuentaHandler::class,
            UpdateCuentaCommand::class => UpdateCuentaHandler::class,
            DestroyCuentaCommand::class => DestroyCuentaHandler::class,
            ToggleCuentaCommand::class => ToggleCuentaHandler::class,
        ]);
    }
}