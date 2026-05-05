<?php

namespace App\Providers\Propietario\Infrastructure;

use Illuminate\Support\ServiceProvider;
use App\Domains\Propietario\Contracts\PropietarioHasCuentasCheckerContract;
use App\Infrastructure\Propietario\Persistence\Checkers\Eloquent\EloquentPropietarioHasCuentasChecker;

class PropietarioHasCuentasCheckerProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(PropietarioHasCuentasCheckerContract::class, EloquentPropietarioHasCuentasChecker::class);
    }
}
