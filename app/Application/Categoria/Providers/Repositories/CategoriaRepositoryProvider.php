<?php

namespace App\Application\Categoria\Providers\Repositories;

use Illuminate\Support\ServiceProvider;
use App\Domains\Categoria\Contracts\Repositories\CategoriaReadRepositoryContract;
use App\Domains\Categoria\Contracts\Repositories\CategoriaWriteRepositoryContract;
use App\Infrastructure\Persistence\Repositories\Eloquent\Categoria\EloquentCategoriaReadRepository;
use App\Infrastructure\Persistence\Repositories\Eloquent\Categoria\EloquentCategoriaWriteRepository;

class CategoriaRepositoryProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(CategoriaReadRepositoryContract::class, EloquentCategoriaReadRepository::class);
        $this->app->singleton(CategoriaWriteRepositoryContract::class, EloquentCategoriaWriteRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
