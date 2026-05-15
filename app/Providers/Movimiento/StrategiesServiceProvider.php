<?php

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
