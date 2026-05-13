<?php

namespace App\Domains\Movimiento\Contracts\Strategies;

use App\Domains\Cuenta\Aggregates\Cuenta;

/**
 * Contrato que define estrategias para resolver validaciones de transacciones con su propia logica.
 * por ejemplo para transacciones de movimientos tipo gastos o ingresos, cada una implementa su logica diferente.
 * Este contrato garantiza extensibilidad, por si el dia de mañana se añade un nuevo tipo de transaccion, se crea su strategy pertinente para su validacion a la hora de almacenar o actualizar un movimeinto.
 */
interface TransactionValidatorStrategyContract
{
    public function validate(Cuenta $cuenta, float $monto): bool;
    public function supports(int $tipo_movimiento_id): bool;
}
