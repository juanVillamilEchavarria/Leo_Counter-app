<?php

namespace App\Providers\Categoria\Application;
use Illuminate\Support\ServiceProvider;
use App\Shared\Application\Contracts\Queries\Executors\FormOptions\ListTipoMovimientoForFormContract;
use App\Infrastructure\TipoMovimiento\Queries\Executors\Eloquent\EloquentListTipoMovimientoForFormQueryExecutor;

class ListCategoriaFormOptionsProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(ListTipoMovimientoForFormContract::class, EloquentListTipoMovimientoForFormQueryExecutor::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
