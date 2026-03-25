<?php

namespace App\Domains\Reporte\Repositories\Contracts;
use Illuminate\Support\Collection;
use App\Domains\Reporte\DTOs\ReporteQueryDTO;
interface ReporteRepositoryContract{
    /**
     * @return Collection<stdClass>
     */
    public function getKPIs(ReporteQueryDTO $dto): Collection;
    /**
     * @return Collection<stdClass>
     */
    public function getBalanceNeto(ReporteQueryDTO $dto): Collection;
    public function getTotalPresupuesto(ReporteQueryDTO $dto): float;
    /**
     * @return Collection<stdClass>
     */
    public function getCategoryDistribution(ReporteQueryDTO $dto): Collection;
    /**
     * @return Collection<stdClass>
     */
    public function getIngresosVsGastos(ReporteQueryDTO $dto): Collection;
    /**
     * @return Collection<stdClass>
     */
    public function getIngresos(ReporteQueryDTO $dto): Collection;
    /**
     * @return Collection<stdClass>
     */
    public function getGastos(ReporteQueryDTO $dto): Collection;
    public function getTotalGastos(ReporteQueryDTO $dto): float;
}