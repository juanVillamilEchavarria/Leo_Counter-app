<?php

namespace App\Providers\Movimiento;

use Illuminate\Support\ServiceProvider;
use App\Domains\Movimiento\Strategies\Transaction\Revert\RevertGastoEffectForCuentaWhenMovimientoIsChangedStrategy;
use App\Domains\Movimiento\Strategies\Transaction\Revert\RevertIngresoEffectForCuentaWhenMovimientoIsChanged;
use App\Domains\Movimiento\Strategies\Transaction\Apply\ApplyGastoEffectForCuentaStrategy;
use App\Domains\Movimiento\Strategies\Transaction\Apply\ApplyIngresoEffectForCuentaForCuentaStrategy;
use App\Application\Movimiento\Resolvers\ApplyTransactionEffectForCuentaResolver;
use App\Application\Movimiento\Resolvers\RevertTransactionEffectForCuentaResolver;

class TransactionEffectForCuentaProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->tag([
          RevertIngresoEffectForCuentaWhenMovimientoIsChanged::class,
            RevertGastoEffectForCuentaWhenMovimientoIsChangedStrategy::class,
        ], 'movimiento.revert.transaction.strategies');
        $this->app->tag([
            ApplyIngresoEffectForCuentaForCuentaStrategy::class,
            ApplyGastoEffectForCuentaStrategy::class
        ], 'movimiento.apply.transaction.strategies');

        $this->app->bind(
            RevertTransactionEffectForCuentaResolver::class,
            function(){
            return new RevertTransactionEffectForCuentaResolver(

                    $this->app->tagged('movimiento.revert.transaction.strategies')
            );
        });
        $this->app->bind(
            ApplyTransactionEffectForCuentaResolver::class,
            function(){
                return new ApplyTransactionEffectForCuentaResolver(
                    $this->app->tagged('movimiento.apply.transaction.strategies')
                );
            }
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
