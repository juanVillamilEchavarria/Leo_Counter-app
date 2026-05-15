<?php

namespace App\Domains\Movimiento\Contracts\Strategies;
use App\Application\Movimiento\Contracts\Commands\ModifyMovimientoCommandContract;
use App\Domains\Movimiento\Aggregates\Movimiento;
use App\Domains\Cuenta\Aggregates\Cuenta;
/**
 * Contrato que representa una estrategia para revertir el efecto de una transacción en una cuenta, como por ejemplo un ingreso o un gasto, dependiendo del caso de uso a ejecutar, como pueden ser la actualizacion o eliminacion de un movimiento.
 * Cada tipo de movimiento para cada tipo de caso de uso debe implementar una clase utilizando esta estrategia, devolviendo la cuenta ya con el efecto revertido.
 * @example Si un movimiento se elimina, se debe revertir el efecto de la transacción, es decir, se debe restar o añadir (dependiendo si es tipo ingreso o gasto) el monto del movimiento al saldo de la cuenta
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
interface RevertTransactionEffectForCuentaStrategyContract
{
    /**
     * Determina si la estrategia es compatible con el comando de modificacion de movimiento
     * @param ModifyMovimientoCommandContract $command
     * @param Movimiento $movimiento
     * @return bool
     */
    public function supports(ModifyMovimientoCommandContract $command, Movimiento $movimiento):bool;

    /**
     * revierte el efecto de la transaccion cuando un movimiento cambia a sus relaciones y a sus propias propiedades, garantizando la integridad de los datos
     * @param Movimiento $movimiento - el movimiento ANTES de ser modificado (actualizado)
     * @param ModifyMovimientoCommandContract $command
     * @param Cuenta $cuenta - la cuenta relacionada con el comando (o del movimiento si son el mismo)
     * @return Cuenta - la cuenta ya con el efecto revertido
     */
    public function revertTransactionEffectWhenAMovimientoChanges(ModifyMovimientoCommandContract $command, Movimiento $movimiento, Cuenta $cuenta):Cuenta;

}
