<?php

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
