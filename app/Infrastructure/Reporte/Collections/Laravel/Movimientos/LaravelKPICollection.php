<?php

namespace App\Infrastructure\Reporte\Collections\Laravel\Movimientos;

use App\Domains\Reporte\Contracts\Collections\Movimientos\KPICollectionContract;
use App\Domains\Reporte\ValueObjects\KPI\KPIVO;
use App\Shared\Infrastructure\Framework\Laravel\Collections\LaravelCollection;

/**
 * Implementación Laravel de la colección de KPIs del reporte financiero.
 *
 * @extends LaravelCollection<int, KPIVO>
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 */
final class LaravelKPICollection extends LaravelCollection implements KPICollectionContract
{
    
    public function totalIngresos(): float
    {
        return $this->sum(fn(KPIVO $mes) => $mes->ingresos);
    }

    public function totalGastos(): float
    {
        return $this->sum(fn(KPIVO $mes) => $mes->gastos);
    }

    public function totalBalance(): float
    {
        return $this->sum(fn(KPIVO $mes) => $mes->getBalance());
    }

    public function totalMovimientos(): int
    {
        return $this->sum(fn(KPIVO $mes) => $mes->total_movimientos);
    }
}