<?php

namespace App\Domains\Reporte\Repositories\Contracts;
use Illuminate\Support\Collection;

use Illuminate\Support\Carbon;
interface ReporteRepositoryContract{
    /**
     * @return Collection<stdClass>
     */
    public function getKPIs(Carbon $startDate, Carbon $endDate): Collection;
    /**
     * @return Collection<stdClass>
     */
    public function getBalanceNeto(Carbon $startDate, Carbon $endDate): Collection;
    public function getTotalPresupuesto(Carbon $startDate, Carbon $endDate): float;
    /**
     * @return Collection<stdClass>
     */
    public function getDistributionByCategory(Carbon $startDate, Carbon $endDate, int $tipo_movimiento_id): Collection;
    /**
     * @return Collection<stdClass>
     */
    public function getIngresosVsGastos(Carbon $startDate, Carbon $endDate): Collection;
    /**
     * @return Collection<stdClass>
     */
    public function getIngresos(Carbon $startDate, Carbon $endDate): Collection;
    /**
     * @return Collection<stdClass>
     */
    public function getGastos(Carbon $startDate, Carbon $endDate): Collection;
    public function getTotalGastos(Carbon $startDate, Carbon $endDate): float;
}