<?php

namespace App\Infrastructure\Reporte\Collections\Laravel\Movimientos;

use App\Domains\Reporte\Contracts\Collections\Movimientos\MetricPointCollectionContract;
use App\Domains\Reporte\ValueObjects\Common\MetricPointVO;
use App\Shared\Infrastructure\Framework\Laravel\Collections\LaravelCollection;

/**
 * Implementación Laravel de la colección de puntos métricos (gastos/ingresos) del reporte financiero.
 *
 * @extends LaravelCollection<int, MetricPointVO>
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 */
final class LaravelMetricPointCollection extends LaravelCollection implements MetricPointCollectionContract
{
    public function totalMonto(): int
    {
        return (int) $this->sum(fn(MetricPointVO $item) => $item->monto);
    }

    public function totalRecords(): int
    {
        return $this->count();
    }
}