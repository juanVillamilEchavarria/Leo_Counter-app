<?php

namespace App\Infrastructure\Reporte\Queries\Executors\Presupuestos\Cache;

use App\Application\Reporte\Contracts\Queries\ReporteQueryExecutorContract;
use App\Domains\Reporte\Contracts\Enums\ReportStatisticTypeContract;
use App\Domains\Reporte\ValueObjects\ReporteQuery;
use App\Infrastructure\Reporte\Queries\Executors\Presupuestos\Eloquent\EloquentTotalPresupuestoQueryExecutor;
use Illuminate\Support\Facades\Cache;

/**
 * Decorador que cachea el total de presupuesto en un periodo.
 */
final readonly class CachedTotalPresupuestoQueryExecutor implements ReporteQueryExecutorContract
{
    private const CACHE_TTL = 3600;

    public function __construct(
        private EloquentTotalPresupuestoQueryExecutor $executor
    ) {}

    public function supports(ReportStatisticTypeContract $type): bool
    {
        return $this->executor->supports($type);
    }

    public function execute(ReporteQuery $dto): float
    {
        $cacheKey = sprintf('reporte_total_presupuesto_%s_%s',
            $dto->dateRange->startDate->format('Y-m-d'),
            $dto->dateRange->endDate->format('Y-m-d')
        );

        return Cache::tags(['reportes'])->remember($cacheKey, self::CACHE_TTL, function () use ($dto) {
            return $this->executor->execute($dto);
        });
    }
}
