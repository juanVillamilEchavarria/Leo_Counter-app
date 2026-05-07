<?php

namespace App\Providers\Shared\Domain;

use Illuminate\Support\ServiceProvider;
use App\Shared\Domain\Contracts\IdGeneratorContract;
use App\Shared\Infrastructure\Framework\Laravel\Generators\LaravelIdGenerator;
class IdGeneratorProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(IdGeneratorContract::class, LaravelIdGenerator::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
