<?php

namespace App\Providers\Usuario;

use App\Domains\Usuario\Contracts\Repositories\UsuarioRepositoryContract;
use App\Domains\Usuario\Contracts\Services\PasswordHasherContract;
use App\Infrastructure\Usuario\Persistence\Repositories\Eloquent\EloquentUsuarioRepository;
use App\Infrastructure\Usuario\Services\LaravelPasswordHasher;
use Illuminate\Support\ServiceProvider;

/**
 * Service provider de bindings del módulo Usuario.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Providers\Usuario
 * @since 1.0.0
 * @version 1.0.0
 */
final class UsuarioServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(UsuarioRepositoryContract::class, EloquentUsuarioRepository::class);
        $this->app->singleton(PasswordHasherContract::class, LaravelPasswordHasher::class);
    }
}
