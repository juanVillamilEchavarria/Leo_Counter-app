<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Infrastructure\Reporte\Queries\Executors\Presupuestos\Cache;

use App\Application\Reporte\Contracts\Queries\ReporteQueryExecutorContract;
use App\Domains\Reporte\Contracts\Enums\ReportStatisticTypeContract;
use App\Domains\Reporte\ValueObjects\ReporteQuery;
use App\Infrastructure\Reporte\Queries\Executors\Presupuestos\Eloquent\EloquentUsedBudgetQueryExecutor;
use App\Domains\Reporte\ValueObjects\Budget\UsedBudgetVO;
use Illuminate\Support\Facades\Cache;

/**
 * Decorador que cachea el presupuesto usado (UsedBudgetVO) para un periodo.
 */
final readonly class CachedUsedBudgetQueryExecutor implements ReporteQueryExecutorContract
{
    private const CACHE_TTL = 3600;

    public function __construct(
        private EloquentUsedBudgetQueryExecutor $executor
    ) {}

    public function supports(ReportStatisticTypeContract $type): bool
    {
        return $this->executor->supports($type);
    }

    public function execute(ReporteQuery $dto): UsedBudgetVO
    {
        $cacheKey = sprintf('reporte_used_budget_%s_%s',
            $dto->dateRange->startDate->format('Y-m-d'),
            $dto->dateRange->endDate->format('Y-m-d')
        );

        return Cache::tags(['reportes'])->remember($cacheKey, self::CACHE_TTL, function () use ($dto) {
            return $this->executor->execute($dto);
        });
    }
}
