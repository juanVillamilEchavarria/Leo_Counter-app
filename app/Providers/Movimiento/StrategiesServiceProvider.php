<?php

namespace App\Providers\Movimiento;

use Illuminate\Support\ServiceProvider;
use App\Application\Movimiento\Resolvers\TransactionValidatorResolver;
use App\Domains\Movimiento\Strategies\Domain\IngresoValidatorStrategy;
use App\Domains\Movimiento\Strategies\Domain\GastoValidatorStrategy;

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
