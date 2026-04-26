<?php

namespace App\Providers\Propietario;

use Illuminate\Support\ServiceProvider;
use App\Domains\Propietario\Contracts\Repositories\PropietarioReadRepositoryContract;
use App\Domains\Propietario\Contracts\Repositories\PropietarioRepositoryContract;
use App\Infrastructure\Propietario\Persistence\Repositories\Eloquent\EloquentPropietarioReadRepository;
use App\Infrastructure\Propietario\Persistence\Repositories\Eloquent\EloquentPropietarioRepository;

class PropietarioRepositoryProvider extends ServiceProvider {

    public function register(): void
    {
        $this->app->bind(PropietarioReadRepositoryContract::class, EloquentPropietarioReadRepository::class);
        $this->app->singleton(PropietarioRepositoryContract::class, EloquentPropietarioRepository::class);
    }

}
