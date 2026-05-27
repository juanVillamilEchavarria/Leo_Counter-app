<?php

namespace App\Infrastructure\MovimientoPendiente\Queries\Executors\Eloquent;

use App\Application\MovimientoPendiente\Contracts\Queries\Executors\MovimientoPendienteQueryExecutorContract;
use App\Application\MovimientoPendiente\Contracts\Queries\ListMovimientoPendienteQueryContract;
use App\Domains\Categoria\ValueObjects\CategoriaId;
use App\Domains\Cuenta\ValueObjects\CuentaId;
use App\Domains\MovimientoFijo\ValueObjects\MovimientoFijoId;
use App\Domains\MovimientoPendiente\ValueObjects\MovimientoPendienteId;
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;
use App\Shared\Domain\Contracts\CollectionContract;
use App\Domains\MovimientoPendiente\Aggregates\MovimientoPendiente;
use App\Models\MovimientoPendiente\MovimientoPendiente as Model;
use App\Shared\Domain\ValueObjects\Amount;
use App\Shared\Infrastructure\Framework\Laravel\Collections\LaravelCollection;
use App\Domains\MovimientoPendiente\Enums\EstadosMovimientoPendiente;
use App\Shared\Domain\ValueObjects\Date;
use Carbon\Carbon;

/**
 * Ejecutor de la query para obtener los movimientos pendientes que deben ser procesados.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Infrastructure\MovimientoPendiente\Queries\Executors\Eloquent
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class EloquentListAllMovimientoPendienteDueForProcessingQueryExecutor implements MovimientoPendienteQueryExecutorContract
{

    /**
     * @inheritDoc
     */
    public function execute(ListMovimientoPendienteQueryContract $query): CollectionContract
    {
       $models = Model::where('estado', '=', EstadosMovimientoPendiente::PENDIENTE->value)
           ->whereDate('fecha_programada','<=', Carbon::now()->format('Y-m-d'))->get();
       $aggregates = $models->map(function (Model $movimientoPendiente) {
           return MovimientoPendiente::create(
               id: new MovimientoPendienteId($movimientoPendiente->id),
               categoria_id: new CategoriaId($movimientoPendiente->categoria_id),
               cuenta_id: new CuentaId($movimientoPendiente->cuenta_id),
               tipo_movimiento_id: TipoMovimientoEnum::try($movimientoPendiente->tipo_movimiento_id),
               nombre: $movimientoPendiente->nombre,
               monto: new Amount($movimientoPendiente->monto),
               fecha_programada: new Date($movimientoPendiente->fecha_programada),
               descripcion: $movimientoPendiente->descripcion,
               estado: EstadosMovimientoPendiente::try($movimientoPendiente->estado),
               movimiento_fijo_id: new MovimientoFijoId($movimientoPendiente->movimiento_fijo_id)
           );
       });

       return LaravelCollection::make($aggregates);
    }
}
