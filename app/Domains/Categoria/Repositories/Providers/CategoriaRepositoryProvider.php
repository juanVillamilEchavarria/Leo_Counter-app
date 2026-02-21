<?php

namespace App\Domains\Categoria\Repositories\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domains\Categoria\Repositories\Contracts\CategoriaReadRepositoryContract;
use App\Domains\Categoria\Repositories\Application\Eloquent\EloquentCategoriaReadRepository;

class CategoriaRepositoryProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(CategoriaReadRepositoryContract::class, EloquentCategoriaReadRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
