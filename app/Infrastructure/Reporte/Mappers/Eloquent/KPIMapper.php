<?php

namespace App\Infrastructure\Reporte\Mappers\Eloquent;

use App\Infrastructure\Reporte\Collections\Laravel\Movimientos\LaravelKPICollection;
use App\Domains\Reporte\Contracts\Collections\Movimientos\KPICollectionContract;
use App\Domains\Reporte\ValueObjects\KPI\KPIVO;
use Illuminate\Support\Collection;

/**
 * Mapper usado en las consultas de eloquent, para mappear los resultados de la base de datos a objetos de valor específicos del dominio, en este caso para la collección de KPI.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @version 1.0.0
 * @since 1.0.0
 * @see App\Domains\Reporte\Contracts\Collections\Movimientos\KPICollectionContract
 */
final class KPIMapper
{
    public function map(Collection $rows): KPICollectionContract
    {
        $mapped = $rows->map(static function ($row) {
            return new KPIVO(
                (float) $row->total_ingresos,
                (float) $row->total_gastos,
                (int) $row->total_movimientos
            );
        });

        return LaravelKPICollection::make($mapped);
    }
}
