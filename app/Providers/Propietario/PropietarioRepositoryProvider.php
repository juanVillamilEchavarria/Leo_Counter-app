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
use App\Domains\Propietario\Contracts\Repositories\PropietarioRepositoryContract;
use App\Infrastructure\Propietario\Persistence\Repositories\Eloquent\EloquentPropietarioRepository;

class PropietarioRepositoryProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(PropietarioRepositoryContract::class, EloquentPropietarioRepository::class);
    }
}
