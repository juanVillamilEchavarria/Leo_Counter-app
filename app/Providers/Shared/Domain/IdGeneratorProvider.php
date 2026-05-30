<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
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
