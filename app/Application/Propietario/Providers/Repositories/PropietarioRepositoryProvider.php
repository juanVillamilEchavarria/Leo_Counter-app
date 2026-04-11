<?php

namespace App\Application\Propietario\Providers\Repositories;

use Illuminate\Support\ServiceProvider;
use App\Domains\Propietario\Contracts\Repositories\PropietarioReadRepositoryContract;
use App\Domains\Propietario\Contracts\Repositories\PropietarioWriteRepositoryContract;
use App\Infrastructure\Persistence\Repositories\Eloquent\Propietario\EloquentPropietarioReadRepository;
use App\Infrastructure\Persistence\Repositories\Eloquent\Propietario\EloquentPropietarioWriteRepository;

class PropietarioRepositoryProvider extends ServiceProvider {

    public function register(): void
    {
        $this->app->bind(PropietarioReadRepositoryContract::class, EloquentPropietarioReadRepository::class);
        $this->app->singleton(PropietarioWriteRepositoryContract::class, EloquentPropietarioWriteRepository::class);
    }

}
