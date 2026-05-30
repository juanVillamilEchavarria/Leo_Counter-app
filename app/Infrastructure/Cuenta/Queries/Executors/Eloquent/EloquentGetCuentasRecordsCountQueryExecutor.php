<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Infrastructure\Cuenta\Queries\Executors\Eloquent;

use App\Application\Cuenta\Contracts\Queries\Executors\GetCuentaRecordsCountQueryExecutorContract;
use App\Models\Cuenta\Cuenta;

/**
 * QueryExecutor encargado de obtener el conteo total de registros de cuentas usando Eloquent.
 * Este executor implementa un contrato específico para el caso de uso de conteo de registros de cuentas.
 */
final readonly class EloquentGetCuentasRecordsCountQueryExecutor implements GetCuentaRecordsCountQueryExecutorContract
{
    public function execute(): int
    {
        return Cuenta::count();
    }
}
