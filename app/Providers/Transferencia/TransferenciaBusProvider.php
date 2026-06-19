<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
namespace App\Providers\Transferencia;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Bus;
use App\Application\Transferencia\Commands\StoreTransferenciaCommand;
use App\Application\Transferencia\Commands\Handlers\StoreTransferenciaHandler;

class TransferenciaBusProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Bus::map([
            StoreTransferenciaCommand::class => StoreTransferenciaHandler::class,
        ]);
    }
}
