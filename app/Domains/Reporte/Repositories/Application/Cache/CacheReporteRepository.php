<?php
namespace App\Domains\Reporte\Repositories\Application\Cache;

use App\Domains\Reporte\Repositories\Contracts\ReporteRepositoryContract;
use App\Domains\Reporte\Repositories\Application\Eloquent\EloquentReporteRepository;
use App\Domains\Reporte\DTOs\ReporteQueryDTO;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class CacheReporteRepository implements ReporteRepositoryContract{

    /**
     * Tiempo de cache
     */
    protected int $time= 10; 
    public function __construct(
        private EloquentReporteRepository $eloquentReporteRepository
    )
    {
    }

    /**
     * Genera la llave para el cache dependiendo del metodo a ejecutar y la informacion del reporte
     * @param string $method
     * @param ReporteQueryDTO $dto
     * @return string
     */
    private function cacheKey(string $method, ReporteQueryDTO $dto): string {
        return sprintf(
            'reporte.%s.%s.%s.%s.%s.%s.%s',
            $method,
            $dto->granularityStrategy->groupBy(),
            $dto->dateRange->startDate->toDateString(),
            $dto->dateRange->endDate->toDateString(),
            $dto->only_categorias_fijas,
            $dto->categorias,
            $dto->cuentas
        );
    }

    /**
     * Metodo para unificar el tiempo de cache para todos los metodos
     */
    private function getCacheTime(){
        return now()->addMinutes($this->time);
    }

    public function setTime(int $time){
        $this->time = $time;
        return $this;
    }
    public function getBalanceNeto(ReporteQueryDTO $dto): Collection
    {
        return Cache::remember(
            $this->cacheKey('balance-neto', $dto),
            $this->getCacheTime(),
            fn() => $this->eloquentReporteRepository->getBalanceNeto($dto)
        );
    }
    public function getKPIs(ReporteQueryDTO $dto): Collection
    {
        return Cache::remember(
            $this->cacheKey('kpi', $dto),
            $this->getCacheTime(),
            fn() => $this->eloquentReporteRepository->getKPIs($dto)
        );
    }
    public function getCategoryDistribution(ReporteQueryDTO $dto): Collection
    {
        return Cache::remember(
            $this->cacheKey('category-distribution', $dto),
            $this->getCacheTime(),
            fn() => $this->eloquentReporteRepository->getCategoryDistribution($dto)
        );
    }

    public function getGastos(ReporteQueryDTO $dto): Collection
    {
        return Cache::remember(
            $this->cacheKey('gastos', $dto),
            $this->getCacheTime(),
            fn() => $this->eloquentReporteRepository->getGastos($dto)
        );
    }

    public function getIngresos(ReporteQueryDTO $dto): Collection
    {
        return Cache::remember(
            $this->cacheKey('ingresos', $dto),
            $this->getCacheTime(),
            fn() => $this->eloquentReporteRepository->getIngresos($dto)
        );
    }

    public function getIngresosVsGastos(ReporteQueryDTO $dto): Collection
    {
        return Cache::remember(
            $this->cacheKey('ingresos-vs-gastos', $dto),
            $this->getCacheTime(),
            fn() => $this->eloquentReporteRepository->getIngresosVsGastos($dto)
        );
    }

    public function getTotalGastos(ReporteQueryDTO $dto): float
    {
        return Cache::remember(
            $this->cacheKey('total-gastos', $dto),
            $this->getCacheTime(),
            fn() => $this->eloquentReporteRepository->getTotalGastos($dto)
        );
    }

    public function getTotalPresupuesto(ReporteQueryDTO $dto): float
    {
        return Cache::remember(
            $this->cacheKey('total-presupuesto', $dto),
            $this->getCacheTime(),
            fn() => $this->eloquentReporteRepository->getTotalPresupuesto($dto)
        );
    }

    public function forgetCache(){
        Cache::forget('reporte.*');
    }
}