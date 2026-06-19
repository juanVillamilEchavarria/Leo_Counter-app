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
use Illuminate\Support\Facades\Event;
use App\Domains\Transferencia\Events\TransferenciaCreated;
use App\Application\Transferencia\EventHandlers\ApplyTransactionEffectForCuentaWhenTransferenciaWasCreatedEventHandler;

class TransferenciaEventHandlersProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Event::listen(
            TransferenciaCreated::class,
            ApplyTransactionEffectForCuentaWhenTransferenciaWasCreatedEventHandler::class
        );
    }
}
