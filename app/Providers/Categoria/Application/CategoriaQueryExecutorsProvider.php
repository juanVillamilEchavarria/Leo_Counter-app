<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Providers\Categoria\Application;

use App\Application\Categoria\Queries\Handlers\ListAllCategoriasWithDetailsHandler;
use App\Application\Categoria\Queries\Handlers\GetCategoriaRecordsCountHandler;
use App\Application\Categoria\Queries\Handlers\ListCategoriaFormOptionsHandler;
use App\Infrastructure\Categoria\Queries\Executors\Eloquent\EloquentListAllCategoriasWithDetailsQueryExecutor;
use App\Infrastructure\Categoria\Queries\Executors\Eloquent\EloquentGetCategoriaRecordsCountQueryExecutor;
use App\Infrastructure\TipoMovimiento\Queries\Executors\Eloquent\EloquentListAllTipoMovimientoQueryExecutor;
use App\Application\Categoria\Contracts\Queries\Executors\CategoriaQueryExecutorContract;
use App\Application\Categoria\Contracts\Queries\Executors\GetCategoriaRecordsCountQueryExecutorContract;
use App\Application\Categoria\Contracts\Queries\Executors\ListCategoryFormOptionQueryExecutorContract;
use Illuminate\Support\ServiceProvider;

class CategoriaQueryExecutorsProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->when(ListAllCategoriasWithDetailsHandler::class)
            ->needs(CategoriaQueryExecutorContract::class)
            ->give(EloquentListAllCategoriasWithDetailsQueryExecutor::class);

        $this->app->when(GetCategoriaRecordsCountHandler::class)
            ->needs(GetCategoriaRecordsCountQueryExecutorContract::class)
            ->give(EloquentGetCategoriaRecordsCountQueryExecutor::class);

        $this->app->when(ListCategoriaFormOptionsHandler::class)
            ->needs(ListCategoryFormOptionQueryExecutorContract::class)
            ->give(EloquentListAllTipoMovimientoQueryExecutor::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
