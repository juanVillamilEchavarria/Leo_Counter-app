<?php

namespace App\Providers\Cuenta\Application;

use Illuminate\Support\ServiceProvider;
use App\Application\Cuenta\Contracts\Queries\Executors\FormOptions\ListPropietarioForFormContract;
use App\Application\Cuenta\Contracts\Queries\Executors\FormOptions\ListTipoCuentaForFormContract;
use App\Infrastructure\TipoCuenta\Queries\Executors\Eloquent\EloquentListTipoCuentaForForm;
use App\Infrastructure\Propietario\Queries\Executors\Eloquent\EloquentListPropietarioForForm;
class ListCuentaFormOptionsProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(ListPropietarioForFormContract::class, EloquentListPropietarioForForm::class);
        $this->app->singleton(ListTipoCuentaForFormContract::class, EloquentListTipoCuentaForForm::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
