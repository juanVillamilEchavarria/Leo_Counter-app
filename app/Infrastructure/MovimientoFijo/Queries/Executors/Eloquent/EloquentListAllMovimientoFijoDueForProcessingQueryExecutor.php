<?php

namespace App\Infrastructure\MovimientoFijo\Queries\Executors\Eloquent;

use App\Application\MovimientoFijo\Contracts\Queries\Executors\MovimientoFijoQueryExecutorContract;
use App\Application\MovimientoFijo\Contracts\Queries\ListMovimientoFijoQueryContract;
use App\Domains\Categoria\ValueObjects\CategoriaId;
use App\Domains\Cuenta\ValueObjects\CuentaId;
use App\Domains\MovimientoFijo\ValueObjects\MovimientoFijoId;
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;
use App\Shared\Domain\Contracts\CollectionContract;
use App\Models\MovimientoFijo\MovimientoFijo;
use App\Domains\MovimientoFijo\Aggregates\MovimientoFijo as MovimientoFijoAggregate;
use App\Shared\Domain\ValueObjects\Amount;
use App\Shared\Domain\ValueObjects\Date;
use App\Shared\Infrastructure\Framework\Laravel\Collections\LaravelCollection;
use Carbon\Carbon;

/**
 * Obtiene todos los movimientos fijos para ser procesados por la automatizacion diaria.
 * obtiene los que su fecha proximo son menores o igual a hoy, y devuelve una coleccion de agregados
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Infrastructure\MovimientoFijo\Queries\Executors\Eloquent
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class EloquentListAllMovimientoFijoDueForProcessingQueryExecutor implements MovimientoFijoQueryExecutorContract
{

    /**
     * @inheritDoc
     */
    public function execute(ListMovimientoFijoQueryContract $query): CollectionContract
    {
        $records = MovimientoFijo::where('fecha_proximo', '<=', Carbon::now()->format('Y-m-d'))->get();
        $aggregates = $records->map(function (MovimientoFijo $record) {
            return MovimientoFijoAggregate::reconstitute(
                id: new MovimientoFijoId($record->id),
                categoria_id: new CategoriaId($record->categoria_id),
                cuenta_id: new CuentaId($record->cuenta_id),
                tipo_movimiento_id: TipoMovimientoEnum::try($record->tipo_movimiento_id),
                frecuencia_movimiento_id: $record->frecuencia_movimiento_id,
                nombre: $record->nombre,
                monto: new Amount($record->monto),
                fecha_proximo: new Date($record->fecha_proximo),
                dias_aviso: $record->dias_aviso,
                descripcion: $record->descripcion,
                active: $record->active,
                registrar_automatico: $record->registrar_automatico,
            );
        });
        return new LaravelCollection($aggregates);
    }
}
