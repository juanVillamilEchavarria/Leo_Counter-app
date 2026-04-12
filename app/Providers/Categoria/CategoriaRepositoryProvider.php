<?php

namespace App\Providers$domain\Repositories;

use Illuminate\Support\ServiceProvider;
use App\Domains\Categoria\Contracts\Repositories\CategoriaReadRepositoryContract;
use App\Domains\Categoria\Contracts\Repositories\CategoriaWriteRepositoryContract;
use App\Infrastructure\Categoria\Persistence\Repositories\Eloquent\EloquentCategoriaReadRepository;
use App\Infrastructure\Categoria\Persistence\Repositories\Eloquent\EloquentCategoriaWriteRepository;

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
