<?php
namespace App\Infrastructure\TipoMovimiento\Queries\Executors\Eloquent;
use App\Models\TipoMovimiento\TipoMovimiento;
use App\Shared\Application\Contracts\Queries\Executors\FormOptions\ListTipoMovimientoForFormContract;
use App\Shared\Infrastructure\Framework\Laravel\Collections\LaravelCollection;

/**
 * Implementación del query executor para obtener los tipo de movimientos utilizando Eloquent ORM.
 * Esta clase se encarga de ejecutar la consulta para obtener todos los registros de tipo de movimiento y devolverlos como una colección de Laravel.
 * Implementa el contrato ListTipoMovimientoForFormContract para ser utilizada en el handler correspondiente.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Infrastructure\TipoMovimiento\Queries\Executors\Eloquent
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class EloquentListTipoMovimientoForFormExecutor implements ListTipoMovimientoForFormContract
{
    public function execute(): LaravelCollection
    {
        return new LaravelCollection(TipoMovimiento::all(['id', 'tipo_movimiento']));
    }
}