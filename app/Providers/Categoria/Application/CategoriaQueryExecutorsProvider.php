<?php

namespace App\Providers\Categoria\Application;

use App\Application\Categoria\Queries\Handlers\ListAllCategoriesWithDetailsHandler;
use App\Application\Categoria\Queries\Handlers\ListCategoriesRecordsCountHandler;
use App\Application\Categoria\Queries\Handlers\ListCategoryFormOptionsHandler;
use App\Infrastructure\Categoria\Queries\Executors\Eloquent\EloquentListAllCategoriesWithDetailsQueryExecutor;
use App\Infrastructure\Categoria\Queries\Executors\Eloquent\EloquentGetCategoriesRecordsCountQueryExecutor;
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
        $this->app->when(ListAllCategoriesWithDetailsHandler::class)
            ->needs(CategoriaQueryExecutorContract::class)
            ->give(EloquentListAllCategoriesWithDetailsQueryExecutor::class);

        $this->app->when(ListCategoriesRecordsCountHandler::class)
            ->needs(GetCategoriaRecordsCountQueryExecutorContract::class)
            ->give(EloquentGetCategoriesRecordsCountQueryExecutor::class);

        $this->app->when(ListCategoryFormOptionsHandler::class)
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
