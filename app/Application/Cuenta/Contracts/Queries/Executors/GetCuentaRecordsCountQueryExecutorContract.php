<?php

namespace App\Application\Cuenta\Contracts\Queries\Executors;

/**
 * Contrato que debe implementar el query executor encargado de obtener el número de registros de cuentas.
 * Este executor corresponde a un caso de uso específico de conteo de registros, separado del contrato general de consultas de cuentas.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Cuenta\Contracts\Queries\Executors
 * @since 1.0.0
 * @version 1.0.0
 */
interface GetCuentaRecordsCountQueryExecutorContract
{
    /**
     * Ejecuta la consulta para obtener el número total de cuentas.
     * @return int
     */
    public function execute(): int;
}
