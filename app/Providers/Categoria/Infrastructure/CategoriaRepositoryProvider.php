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

use Illuminate\Support\ServiceProvider;
use App\Domains\Categoria\Contracts\Repositories\CategoriaReadRepositoryContract;
use App\Domains\Categoria\Contracts\Repositories\CategoriaRepositoryContract;
use App\Infrastructure\Categoria\Persistence\Repositories\Eloquent\EloquentCategoriaReadRepository;
use App\Infrastructure\Categoria\Persistence\Repositories\Eloquent\EloquentCategoriaRepository;

class CategoriaRepositoryProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(CategoriaReadRepositoryContract::class, EloquentCategoriaReadRepository::class);
        $this->app->singleton(CategoriaRepositoryContract::class, EloquentCategoriaRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
