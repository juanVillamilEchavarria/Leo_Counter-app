<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Providers\Shared\Application;

use Illuminate\Support\ServiceProvider;
use App\Shared\Application\Contracts\Queries\Executors\FormOptions\ListCuentaForFormContract;
use App\Shared\Application\Contracts\Queries\Executors\FormOptions\ListCategoriaForFormContract;
use App\Infrastructure\Cuenta\Queries\Executors\Eloquent\EloquentListCuentaForFormQueryExecutor;
use App\Infrastructure\Categoria\Queries\Executors\Eloquent\EloquentListCategoriaForFormQueryExecutor;
use App\Shared\Application\Contracts\Queries\Executors\FormOptions\ListUsuarioForFormContract;
use App\Infrastructure\Usuario\Queries\Executors\Eloquent\EloquentListUsuarioForFormQueryExecutor;
class ListForFormProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(ListCuentaForFormContract::class, EloquentListCuentaForFormQueryExecutor::class);
        $this->app->singleton(ListCategoriaForFormContract::class, EloquentListCategoriaForFormQueryExecutor::class);
        $this->app->singleton(ListUsuarioForFormContract::class, EloquentListUsuarioForFormQueryExecutor::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
