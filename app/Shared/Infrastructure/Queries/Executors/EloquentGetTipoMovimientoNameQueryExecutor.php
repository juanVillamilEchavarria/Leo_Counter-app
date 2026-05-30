<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Shared\Infrastructure\Queries\Executors;
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;
use App\Shared\Application\Contracts\Queries\Executors\GetTipoMovimientoNameQueryExecutorContract;
use App\Models\TipoMovimiento\TipoMovimiento;

/**
 * Clase de eloquent que trae el nombre del tipo de movimiento correspondiente
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
class EloquentGetTipoMovimientoNameQueryExecutor implements GetTipoMovimientoNameQueryExecutorContract
{
    public function getName(TipoMovimientoEnum $tipoMovimiento): string
    {
        $record = TipoMovimiento::query()->select('tipo_movimiento')->where('id', $tipoMovimiento->value)->get();
        return $record->first()->tipo_movimiento;
    }

}
