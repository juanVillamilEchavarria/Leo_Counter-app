<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Infrastructure\MovimientoPendiente\Queries\Executors\Eloquent;

use App\Application\MovimientoPendiente\Contracts\Queries\Executors\MovimientoPendienteQueryExecutorContract;
use App\Application\MovimientoPendiente\Contracts\Queries\ListMovimientoPendienteQueryContract;
use App\Models\MovimientoPendiente\MovimientoPendiente;
use App\Shared\Domain\Contracts\CollectionContract;
use App\Shared\Infrastructure\Framework\Laravel\Collections\LaravelCollection;

/**
 * Query executor Eloquent para listar movimientos pendientes eliminados.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Infrastructure\MovimientoPendiente\Queries\Executors\Eloquent
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class EloquentListAllMovimientosPendientesDeletedQueryExecutor implements MovimientoPendienteQueryExecutorContract
{
    public function execute(ListMovimientoPendienteQueryContract $query): CollectionContract
    {
        return LaravelCollection::make(
            MovimientoPendiente::onlyTrashed()
                ->with([
                    'categoria',
                    'cuenta',
                    'tipo_movimiento',
                    'movimiento_fijo',
                ])
                ->get()
        );
    }
}
