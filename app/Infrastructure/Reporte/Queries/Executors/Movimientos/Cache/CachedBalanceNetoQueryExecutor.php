<?php

namespace App\Infrastructure\Reporte\Queries\Executors\Movimientos\Cache;

use App\Application\Reporte\Contracts\Queries\ReporteQueryExecutorContract;
use App\Domains\Reporte\Contracts\Enums\ReportStatisticTypeContract;
use App\Domains\Reporte\ValueObjects\ReporteQuery;
use App\Infrastructure\Reporte\Collections\Laravel\Movimientos\LaravelBalanceNetoCollection;
use App\Infrastructure\Reporte\Queries\Executors\Movimientos\Eloquent\EloquentBalanceNetoQueryExecutor;
use Illuminate\Support\Facades\Cache;

/**
 * Decorador que cachea el reporte de balance neto.
 */
final readonly class CachedBalanceNetoQueryExecutor implements ReporteQueryExecutorContract
{
    private const CACHE_TTL = 3600;

    public function __construct(
        private EloquentBalanceNetoQueryExecutor $executor
    ) {}

    public function supports(ReportStatisticTypeContract $type): bool
    {
        return $this->executor->supports($type);
    }

    public function execute(ReporteQuery $dto): LaravelBalanceNetoCollection
    {
        $cacheKey = sprintf('reporte_balance_neto_%s_%s',
            $dto->dateRange->startDate->format('Y-m-d'),
            $dto->dateRange->endDate->format('Y-m-d')
        );

        return Cache::tags(['reportes'])->remember($cacheKey, self::CACHE_TTL, function () use ($dto) {
            return $this->executor->execute($dto);
        });
    }
}
