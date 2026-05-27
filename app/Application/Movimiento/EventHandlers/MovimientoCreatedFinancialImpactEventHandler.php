<?php

namespace App\Application\Movimiento\EventHandlers;
use App\Application\Movimiento\Resolvers\ApplyTransactionEffectForCuentaResolver;
use App\Domains\Cuenta\Contracts\Repositories\CuentaRepositoryContract;
use App\Domains\Movimiento\Contracts\Events\FinancialMovimientoRegisteredEventContract;
use App\Domains\Movimiento\Events\MovimientoCreated;
use App\Application\Movimiento\Resolvers\TransactionValidatorResolver;
/**
 * Manejador del impacto financiero de un movimiento cuando este es creado.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class MovimientoCreatedFinancialImpactEventHandler
{
    public function __construct(
        private ApplyTransactionEffectForCuentaResolver $applyTransactionEffectForCuentaResolver,
        private TransactionValidatorResolver $transactionValidatorResolver,
        private CuentaRepositoryContract $cuentaRepository
    )
    {
    }
    public function __invoke( FinancialMovimientoRegisteredEventContract $event): void
    {
        $this->transactionValidatorResolver->resolve($event->getCuenta(), $event->getMovimiento());
       $cuenta = $this->applyTransactionEffectForCuentaResolver->resolve($event->getMovimiento(), $event->getCuenta());
       $this->cuentaRepository->update($cuenta);
    }

}
