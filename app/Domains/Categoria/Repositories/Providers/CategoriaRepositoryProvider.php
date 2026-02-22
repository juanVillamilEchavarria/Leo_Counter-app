<?php

namespace App\Domains\Categoria\Repositories\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domains\Categoria\Repositories\Contracts\CategoriaReadRepositoryContract;
use App\Domains\Categoria\Repositories\Contracts\CategoriaWriteRepositoryContract;
use App\Domains\Categoria\Repositories\Application\Eloquent\EloquentCategoriaReadRepository;
use App\Domains\Categoria\Repositories\Application\Eloquent\EloquentCategoriaWriteRepository;

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
