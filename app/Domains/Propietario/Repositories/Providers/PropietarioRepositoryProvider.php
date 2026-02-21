<?php

namespace App\Domains\Propietario\Repositories\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domains\Propietario\Repositories\Contracts\PropietarioReadRepositoryContract;
use App\Domains\Propietario\Repositories\Application\Eloquent\EloquentPropietarioReadRepository;

class PropietarioRepositoryProvider extends ServiceProvider {

    public function register(): void
    {
        $this->app->bind(PropietarioReadRepositoryContract::class, EloquentPropietarioReadRepository::class);
    }

}
