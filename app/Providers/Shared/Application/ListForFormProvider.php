<?php

namespace App\Providers\Shared\Application;

use Illuminate\Support\ServiceProvider;
use App\Shared\Application\Contracts\Queries\Executors\FormOptions\ListCuentaForFormContract;
use App\Shared\Application\Contracts\Queries\Executors\FormOptions\ListCategoriaForFormContract;
use App\Infrastructure\Cuenta\Queries\Executors\Eloquent\EloquentListCuentaForFormExecutor;
use App\Infrastructure\Categoria\Queries\Executors\Eloquent\EloquentListCategoriaForFormExecutor;

class ListForFormProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(ListCuentaForFormContract::class, EloquentListCuentaForFormExecutor::class);
        $this->app->singleton(ListCategoriaForFormContract::class, EloquentListCategoriaForFormExecutor::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
