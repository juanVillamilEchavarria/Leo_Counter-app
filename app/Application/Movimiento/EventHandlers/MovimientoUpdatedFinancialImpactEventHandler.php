<?php

namespace App\Application\Movimiento\EventHandlers;

use App\Application\Movimiento\Resolvers\RevertTransactionEffectForCuentaResolver;
use App\Application\Movimiento\Resolvers\ApplyTransactionEffectForCuentaResolver;
use App\Domains\Cuenta\Contracts\Repositories\CuentaRepositoryContract;
use App\Domains\Movimiento\Events\MovimientoUpdated;
use App\Application\Movimiento\Resolvers\TransactionValidatorResolver;
/**
 * Manejador del impacto financiero de un movimiento modificado
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Movimiento\EventHandlers
 * @version 1.0.0
 * @since 1.0.0
 */
final readonly class MovimientoUpdatedFinancialImpactEventHandler
{
    public function __construct(
        private RevertTransactionEffectForCuentaResolver $revertResolver,
        private ApplyTransactionEffectForCuentaResolver $applyResolver,
        private TransactionValidatorResolver $transactionValidatorResolver,
        private CuentaRepositoryContract $cuentaRepository,
    ) {}
    public function __invoke( MovimientoUpdated $event):void
    {

        // la cuenta vieja
        $cuenta = $this->revertResolver->resolve($event->getOldMovimiento(), $event->getOldCuenta());
        $saldo = $cuenta->getSaldoActual();

        if ($event->cuentaChanged()) {
            $cuentaNueva = $this->cuentaRepository->findById($event->getMovimiento()->getCuentaId());
            $this->cuentaRepository->update($cuenta);
            $cuenta = $cuentaNueva;
        }
        $this->transactionValidatorResolver->resolve($cuenta, $event->getMovimiento());
        $cuenta = $this->applyResolver->resolve($event->getMovimiento(), $cuenta);
        $this->cuentaRepository->update($cuenta);

    }

}
