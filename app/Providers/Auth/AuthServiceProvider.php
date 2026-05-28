<?php

namespace App\Providers\Auth;

use App\Application\Auth\Contracts\Builders\PasswordResetEmailFormatBuilderContract;
use App\Domains\Auth\Contracts\Services\PasswordResetTokenServiceContract;
use App\Infrastructure\Auth\Framework\Laravel\Builders\LaravelPasswordResetEmailFormatBuilder;
use App\Infrastructure\Auth\Services\LaravelPasswordResetTokenService;
use Illuminate\Support\ServiceProvider;

/**
 * Provider de servicios del modulo Auth.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Providers\Auth
 * @since 1.0.0
 * @version 1.0.0
 */
final class AuthServiceProvider extends ServiceProvider
{
    /**
     * Registra bindings de servicios y builders de Auth.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(PasswordResetTokenServiceContract::class, LaravelPasswordResetTokenService::class);
        $this->app->singleton(PasswordResetEmailFormatBuilderContract::class, LaravelPasswordResetEmailFormatBuilder::class);
    }

    /**
     * Ejecuta acciones de arranque del provider.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }
}
