<?php

namespace App\Domains\Movimiento\Contracts\Strategies;
use App\Domains\Cuenta\ValueObjects\CuentaId;
use App\Domains\Movimiento\Aggregates\Movimiento;
use App\Domains\Cuenta\Aggregates\Cuenta;
use App\Domains\Movimiento\ValueObjects\RevertTransactionEffectForCuentaResultVO;
use App\Shared\Domain\ValueObjects\Amount;

/**
 * Contrato que representa una estrategia para revertir el efecto de una transacción en una cuenta, como por ejemplo un ingreso o un gasto, dependiendo del caso de uso a ejecutar, como pueden ser la actualizacion o eliminacion de un movimiento.
 * Cada tipo de movimiento  debe implementar una clase utilizando esta estrategia, devolviendo la cuenta asociada al movimiento viejo (antes de modificarse) con el efecto revertido
 * @example Si un movimiento se elimina, se debe revertir el efecto de la transacción, es decir, se debe restar o añadir (dependiendo si es tipo ingreso o gasto) el monto del movimiento al saldo de la cuenta
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
interface RevertTransactionEffectForCuentaStrategyContract
{
    /**
     * Determina si la estrategia es compatible con el comando de modificacion de movimiento
     * @param Movimiento $movimiento - el movimiento ya actualizado
     * @return bool
     */
    public function supports( Movimiento $movimiento):bool;

    /**
     * revierte el efecto de la transaccion cuando un movimiento cambia a sus relaciones y a sus propias propiedades, garantizando la integridad de los datos
     * @param Movimiento $old_movimiento - el movimiento antes de ser modificado
     * @param Cuenta $old_cuenta- La cuenta del movimiento antes de ser modificado
     * @return Cuenta - la cuenta vieja con el efecto revertido
     */
    public function revertTransactionEffectWhenAMovimientoChanges( Movimiento $old_movimiento, Cuenta $old_cuenta):Cuenta;

}
