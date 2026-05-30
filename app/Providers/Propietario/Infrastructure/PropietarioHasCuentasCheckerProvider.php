<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
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
