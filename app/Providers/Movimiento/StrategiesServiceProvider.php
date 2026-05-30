<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Providers\Movimiento;

use App\Application\Movimiento\Resolvers\TransactionValidatorResolver;
use App\Domains\Movimiento\Strategies\Transaction\Validators\GastoValidatorStrategy;
use App\Domains\Movimiento\Strategies\Transaction\Validators\IngresoValidatorStrategy;
use Illuminate\Support\ServiceProvider;

class StrategiesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(TransactionValidatorResolver::class, function(){
            return new TransactionValidatorResolver(
                [
                    app(IngresoValidatorStrategy::class),
                    app(GastoValidatorStrategy::class)
                ]
            );
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
