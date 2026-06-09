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

use App\Application\MovimientoPendiente\Contracts\Queries\Executors\MovimientoPendienteForShowQueryExecutorContract;
use App\Application\MovimientoPendiente\DTOs\MovimientoPendienteShowDTO;
use App\Domains\MovimientoPendiente\ValueObjects\MovimientoPendienteId;
use App\Models\MovimientoPendiente\MovimientoPendiente;

/**
 * Executor Eloquent para obtener un movimiento pendiente con sus relaciones principales para visualizacion.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Infrastructure\MovimientoPendiente\Queries\Executors\Eloquent
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class EloquentMovimientoPendienteForShowQueryExecutor implements MovimientoPendienteForShowQueryExecutorContract
{
    /**
     * @inheritDoc
     */
    public function execute(MovimientoPendienteId $id): MovimientoPendienteShowDTO
    {
        $registro = MovimientoPendiente::where('id', $id->getValue())->with([
            'categoria:nombre,id',
            'cuenta:nombre,id',
            'tipo_movimiento:tipo_movimiento,id',
            'movimiento_fijo:nombre,id',
        ])->first();

        return new MovimientoPendienteShowDTO(
            id: $registro->id,
            nombre: $registro->nombre,
            descripcion: $registro->descripcion,
            tipo_movimiento: $registro->tipo_movimiento->tipo_movimiento,
            categoria: $registro->categoria->nombre,
            cuenta: $registro->cuenta->nombre,
            movimiento_fijo: $registro->movimiento_fijo?->nombre,
            fecha_programada: $registro->fecha_programada,
            monto: (float) $registro->monto,
            estado: $registro->estado,
            dias_aviso: $registro->dias_aviso,
        );
    }
}
