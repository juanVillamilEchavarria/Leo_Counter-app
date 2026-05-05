<?php

namespace App\Providers\Propietario\Infrastructure;

use Illuminate\Support\ServiceProvider;
use App\Domains\Propietario\Contracts\PropietarioUniquenessCheckerContract;
use App\Infrastructure\Propietario\Persistence\Checkers\Eloquent\EloquentPropietarioUniquenessChecker;

class PropietarioUniquenessCheckerProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(PropietarioUniquenessCheckerContract::class, EloquentPropietarioUniquenessChecker::class);
    }
}
