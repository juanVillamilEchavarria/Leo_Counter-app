<?php

namespace App\Infrastructure\Reporte\Collections\Laravel\Presupuestos;

use App\Domains\Reporte\ValueObjects\Budget\UsedBudgetVO;
use App\Domains\Reporte\Contracts\Collections\Presupuestos\UsedBudgetCollectionContract;
use App\Shared\Infrastructure\Framework\Laravel\Collections\LaravelCollection;
use App\Shared\Domain\Services\Financial\PercentageService;

final  class LaravelUsedBudgetCollection extends LaravelCollection implements UsedBudgetCollectionContract
{
    public function totalPresupuesto(): float
    {
        return $this->reduce(fn ($carry, UsedBudgetVO $item) => $carry + $item->presupuestado, 0);
    }

    public function totalGastos(): float
    {
        return $this->reduce(fn ($carry, UsedBudgetVO $item) => $carry + $item->gastado, 0);
    }

    public function disponible(): float
    {
        $total = $this->totalPresupuesto() - $this->totalGastos();
        return $total < 0 ? 0 : $total;
    }

    public function percentageUsed(): float
    {
        return (new PercentageService())->calculatePercentage($this->totalGastos(), $this->totalPresupuesto());
    }
}