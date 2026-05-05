<?php

namespace App\Providers\Shared\Application;

use Illuminate\Support\ServiceProvider;
use App\Shared\Application\Contracts\Queries\QueryExecutors\FormOptions\ListCuentaForFormContract;
use App\Shared\Application\Contracts\Queries\QueryExecutors\FormOptions\ListCategoriaForFormContract;
use App\Infrastructure\Cuenta\Queries\Executors\Eloquent\EloquentListCuentaForFormQueryExecutor;
use App\Infrastructure\Categoria\Queries\Executors\Eloquent\EloquentListCategoriaForFormQueryExecutor;

class ListForFormProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(ListCuentaForFormContract::class, EloquentListCuentaForFormQueryExecutor::class);
        $this->app->singleton(ListCategoriaForFormContract::class, EloquentListCategoriaForFormQueryExecutor::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
