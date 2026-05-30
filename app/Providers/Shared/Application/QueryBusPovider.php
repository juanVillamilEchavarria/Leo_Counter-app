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
use App\Shared\Infrastructure\Framework\Laravel\Buses\LaravelQueryBus;
use App\Shared\Application\Contracts\Bus\QueryBus;

class QueryBusPovider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(QueryBus::class, LaravelQueryBus::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
