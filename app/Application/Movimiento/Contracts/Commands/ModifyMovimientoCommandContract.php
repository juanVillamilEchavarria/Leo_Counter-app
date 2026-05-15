<?php

namespace App\Application\Movimiento\Contracts\Commands;

use App\Domains\Movimiento\Contracts\Strategies\RevertTransactionEffectForCuentaStrategyContract;


/**
 * Contrato que deben implementar los queries los cuales escriben un movimeinto,ya sea almacenandolo, actualizandolo o eliminandolo.
 * Este contrato debe ser implementado para poder ser usado en el RevertTransactionEffectStrategyContract, el cual se encarga de la logica de revertir el efecto de una transaccion (movimiento) cuando este es eliminado o actualizado.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 * @see RevertTransactionEffectForCuentaStrategyContract
 */
interface ModifyMovimientoCommandContract
{

}
