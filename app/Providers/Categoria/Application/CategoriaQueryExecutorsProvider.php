<?php

namespace App\Providers\Categoria\Application;
use App\Application\Categoria\Queries\Handlers\ListAllCategoriesWithDetailsHandler;
use App\Application\Categoria\Queries\Handlers\ListCategoriesRecordsCountHandler;
use App\Application\Categoria\Queries\Handlers\ListCategoryFormOptionsHandler;
use App\Infrastructure\Categoria\Queries\Executors\Eloquent\EloquentListAllCategoriesWithDetailsExecutor;
use App\Infrastructure\Categoria\Queries\Executors\Eloquent\EloquentListCategoriesRecordsCountExecutor;
use App\Infrastructure\TipoMovimiento\Queries\Executors\Eloquent\EloquentListAllTipoMovimientoExecutor;
use App\Application\Categoria\Contracts\Queries\Executors\ListCategoriesExecutorContract;
use App\Application\Categoria\Contracts\Queries\Executors\ListCategoryFormOptionExecutorContract;
use Illuminate\Support\ServiceProvider;

class CategoriaQueryExecutorsProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->when(ListAllCategoriesWithDetailsHandler::class)
            ->needs(ListCategoriesExecutorContract::class)
            ->give(EloquentListAllCategoriesWithDetailsExecutor::class);

        $this->app->when(ListCategoriesRecordsCountHandler::class)
            ->needs(ListCategoriesExecutorContract::class)
            ->give(EloquentListCategoriesRecordsCountExecutor::class);

        $this->app->when(ListCategoryFormOptionsHandler::class)
            ->needs(ListCategoryFormOptionExecutorContract::class)
            ->give(EloquentListAllTipoMovimientoExecutor::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
