<?php

namespace App\Providers$domain\Repositories;

use Illuminate\Support\ServiceProvider;
use App\Domains\Propietario\Contracts\Repositories\PropietarioReadRepositoryContract;
use App\Domains\Propietario\Contracts\Repositories\PropietarioWriteRepositoryContract;
use App\Infrastructure\Propietario\Persistence\Repositories\Eloquent\EloquentPropietarioReadRepository;
use App\Infrastructure\Propietario\Persistence\Repositories\Eloquent\EloquentPropietarioWriteRepository;

class PropietarioRepositoryProvider extends ServiceProvider {

    public function register(): void
    {
        $this->app->bind(PropietarioReadRepositoryContract::class, EloquentPropietarioReadRepository::class);
        $this->app->singleton(PropietarioWriteRepositoryContract::class, EloquentPropietarioWriteRepository::class);
    }

}
