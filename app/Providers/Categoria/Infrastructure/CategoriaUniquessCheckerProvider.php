<?php

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
