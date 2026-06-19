<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
namespace App\Application\Transferencia\EventHandlers;

use App\Domains\Cuenta\Contracts\Repositories\CuentaRepositoryContract;
use App\Domains\Transferencia\Events\TransferenciaCreated;
use App\Domains\Transferencia\Exception\CannotExecuteTransferenciaTransactionException;
use App\Shared\Domain\Services\Financial\BalanceCheckerService;

/**
 * Manejador de eventos para aplicar el efecto de la transferencia en las cuentas
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @licence MIT
 */
final readonly class ApplyTransactionEffectForCuentaWhenTransferenciaWasCreatedEventHandler
{
    public function __construct(
        private CuentaRepositoryContract $repository,
        private BalanceCheckerService $balanceCheckerService,
    )
    {
    }

    public function __invoke(TransferenciaCreated $event)
    {
        $transferencia = $event->getTransferencia();
        $cuentaOrigen = $this->repository->findById($transferencia->getCuentaOrigenId());
        if(!$this->balanceCheckerService->canAfford(
            saldo: $cuentaOrigen->getSaldoActual(),
            monto: $transferencia->getMonto())
        ){

            throw new CannotExecuteTransferenciaTransactionException('No se pudo ejecutar la transaccion de transferencia, la cuenta de origen no tiene suficiente saldo');
        }
        $cuentaDestino = $this->repository->findById($transferencia->getCuentaDestinoId());
        if($cuentaOrigen->getId()->equals($cuentaDestino->getId())){
            throw new CannotExecuteTransferenciaTransactionException('No se pudo ejecutar la transaccion de transferencia, la cuenta de origen y la cuenta de destino son la misma');
        }
        $saldoEnviadora = $cuentaOrigen->getSaldoActual();
        $saldoReceptora = $cuentaDestino->getSaldoActual();
        $newSaldoEnviadora= $saldoEnviadora->subtract($transferencia->getMonto());
        $newSaldoReceptora= $saldoReceptora->add($transferencia->getMonto());
        $cuentaOrigen = $cuentaOrigen->updateSaldoActual($newSaldoEnviadora);
        $cuentaDestino= $cuentaDestino->updateSaldoActual($newSaldoReceptora);
        $this->repository->update($cuentaOrigen);
        $this->repository->update($cuentaDestino);
    }

}
