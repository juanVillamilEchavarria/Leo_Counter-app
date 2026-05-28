<?php

namespace App\Providers\Auth;

use App\Domains\Auth\Events\PasswordResetLinkRequested;
use App\Infrastructure\Auth\Framework\Laravel\EventHandlers\LaravelSendPasswordResetEmailEventHandler;
use App\Shared\Application\Contracts\Builders\EmailFormatBuilderContract;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

/**
 * Provider de handlers de eventos del modulo Auth.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Providers\Auth
 * @since 1.0.0
 * @version 1.0.0
 */
final class AuthEventHandlersProvider extends ServiceProvider
{
    /**
     * Registra servicios del provider.
     *
     * @return void
     */
    public function register(): void
    {
    }

    /**
     * Registra listeners de eventos de Auth.
     *
     * @return void
     */
    public function boot(): void
    {
        Event::listen(PasswordResetLinkRequested::class, LaravelSendPasswordResetEmailEventHandler::class);
    }
}
