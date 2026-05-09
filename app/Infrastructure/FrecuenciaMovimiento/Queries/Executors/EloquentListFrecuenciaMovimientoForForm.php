<?php

namespace App\Infrastructure\FrecuenciaMovimiento\Queries\Executors;

use App\Models\FrecuenciaMovimiento\FrecuenciaMovimiento;
use App\Shared\Application\Contracts\Queries\Executors\FormOptions\ListFrecuenciaMovimientoForFormContract;
use App\Shared\Domain\Contracts\CollectionContract;
use App\Shared\Infrastructure\Framework\Laravel\Collections\LaravelCollection;

/**
 * Query executor Eloquent para listar frecuencias de movimiento como opciones de formulario.
 * Obtiene solo los campos requeridos por los formularios de configuracion recurrente.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Infrastructure\MovimientoFijo\Queries\Executors\Eloquent
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class EloquentListFrecuenciaMovimientoForForm implements ListFrecuenciaMovimientoForFormContract
{
    public function execute(): CollectionContract
    {
        return LaravelCollection::make(FrecuenciaMovimiento::all(['id', 'frecuencia_movimiento']));
    }
}
