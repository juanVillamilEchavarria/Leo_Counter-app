<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Providers\Auth;

use App\Application\Auth\Commands\Handlers\ResetPasswordHandler;
use App\Application\Auth\Commands\Handlers\SendPasswordResetLinkHandler;
use App\Application\Auth\Commands\ResetPasswordCommand;
use App\Application\Auth\Commands\SendPasswordResetLinkCommand;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\ServiceProvider;

/**
 * Provider de bus del modulo Auth.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Providers\Auth
 * @since 1.0.0
 * @version 1.0.0
 */
final class AuthBusProvider extends ServiceProvider
{
    /**
     * Registra servicios del provider.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Registra el mapeo entre comandos de Auth y sus handlers.
     *
     * @return void
     */
    public function boot(): void
    {
        Bus::map([
            SendPasswordResetLinkCommand::class => SendPasswordResetLinkHandler::class,
            ResetPasswordCommand::class => ResetPasswordHandler::class,
        ]);
    }
}
