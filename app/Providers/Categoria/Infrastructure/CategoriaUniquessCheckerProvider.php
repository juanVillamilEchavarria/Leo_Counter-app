<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Providers\Categoria\Infrastructure;
use App\Domains\Categoria\Contracts\CategoriaUniquenessCheckerContract;
use App\Infrastructure\Categoria\Persistence\Checkers\Eloquent\EloquentCategoriaUniquenessChecker;
use Illuminate\Support\ServiceProvider;

class CategoriaUniquessCheckerProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(CategoriaUniquenessCheckerContract::class, EloquentCategoriaUniquenessChecker::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
