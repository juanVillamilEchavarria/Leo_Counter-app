<?php

namespace App\Infrastructure\Movimiento\Queries\Executors\Eloquent;

use App\Application\Movimiento\Contracts\Queries\Executors\MovimientoForShowQueryExecutorContract;
use App\Application\Movimiento\DTOs\MovimientoShowDTO;
use App\Domains\Movimiento\ValueObjects\MovimientoId;
use App\Models\Movimiento\Movimiento;
use App\Shared\Infrastructure\Framework\Laravel\Collections\LaravelCollection;

class EloquentMovimientoForShowQueryExecutor implements MovimientoForShowQueryExecutorContract
{

    /**
     * @inheritDoc
     */
    public function execute(MovimientoId $id): MovimientoShowDTO
    {
       $movimiento = Movimiento::where('id', $id->getValue())->with([
           'archivoMovimientos:nombre_guardado,nombre_original,path,disk,movimiento_id,id',
           'categoria:nombre,id',
           'cuenta:nombre,id',
           'tipo_movimiento:tipo_movimiento,id',
           'movimientoPendiente:nombre,id'
       ])->first();
       return new MovimientoShowDTO(
           id: $movimiento->id,
           nombre: $movimiento->nombre,
           categoria: $movimiento->categoria->nombre,
           cuenta: $movimiento->cuenta->nombre,
           tipo_movimiento: $movimiento->tipo_movimiento->tipo_movimiento,
           monto: $movimiento->monto,
           fecha: $movimiento->fecha,
           descripcion: $movimiento->descripcion,
           movimiento_pendiente: $movimiento->movimientoPendiente?->nombre,
           comprobantes: LaravelCollection::make($movimiento->archivoMovimientos),
       );
    }
}
