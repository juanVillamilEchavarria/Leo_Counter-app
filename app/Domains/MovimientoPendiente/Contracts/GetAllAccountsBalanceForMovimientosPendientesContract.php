<?php

namespace App\Domains\MovimientoPendiente\Contracts;

/**
 * Contrato para obtener todos los saldos de las cuentas vinculadas a movimientos pendientes de tipo gasto
 * @package App\Domains\MovimientoPendiente\Contracts
 * @version 1.0.0
 * @since 1.0.0
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 */
interface GetAllAccountsBalanceForMovimientosPendientesContract{
    /**
     * Trae todos los saldos de las cuentas vinculadas a movimientos pendientes de tipo gasto
     * @return \App\Shared\Domain\Contracts\CollectionContract - Coleccion de saldos de cuentas, del saldo actual y el id de la cuenta
     */
    public function getAllAccountsBalanceForMovimientosPendientes(): \App\Shared\Domain\Contracts\CollectionContract;
}
