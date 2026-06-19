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

/**
 * Manejador de eventos para aplicar el efecto de la transferencia en las cuentas
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @licence MIT
 */
final readonly class ApplyTransactionEffectForCuentaWhenTransferenciaWasCreatedEventHandler
{
    public function __construct(
        private CuentaRepositoryContract $repository,
    )
    {
    }

    public function __invoke(TransferenciaCreated $event)
    {
        $transferencia = $event->getTransferencia();
        $cuentaEnviadora = $this->repository->findById($transferencia->getCuentaEnviadoraId());
        $cuentaReceptora = $this->repository->findById($transferencia->getCuentaReceptoraId());
        $saldoEnviadora = $cuentaEnviadora->getSaldoActual();
        $saldoReceptora = $cuentaReceptora->getSaldoActual();
        $newSaldoEnviadora= $saldoEnviadora->subtract($transferencia->getMonto());
        $newSaldoReceptora= $saldoReceptora->add($transferencia->getMonto());
        $cuentaEnviadora = $cuentaEnviadora->updateSaldoActual($newSaldoEnviadora);
        $cuentaReceptora= $cuentaReceptora->updateSaldoActual($newSaldoReceptora);

        $this->repository->update($cuentaEnviadora);
        $this->repository->update($cuentaReceptora);
    }

}
