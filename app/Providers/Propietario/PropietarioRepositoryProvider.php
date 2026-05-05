<?php

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
