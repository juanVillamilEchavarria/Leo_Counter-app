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
use App\Shared\Application\Contracts\Queries\Executors\GetTipoMovimientoNameQueryExecutorContract;
use App\Shared\Infrastructure\Queries\Executors\EloquentGetTipoMovimientoNameQueryExecutor;
use App\Shared\Application\Contracts\Queries\Executors\GetUsersWhoCanBeNotifiedQueryExecutorContract;
use App\Infrastructure\Usuario\Queries\Executors\Eloquent\EloquentGetUsersWhoCanBeNotifiedQueryExecutor;


class QueryExecutorsProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(GetTipoMovimientoNameQueryExecutorContract::class, EloquentGetTipoMovimientoNameQueryExecutor::class);
        $this->app->singleton(GetUsersWhoCanBeNotifiedQueryExecutorContract::class, EloquentGetUsersWhoCanBeNotifiedQueryExecutor::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
