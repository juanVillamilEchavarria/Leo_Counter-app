<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Infrastructure\Reporte\Queries\Executors\Movimientos\Cache;

use App\Application\Reporte\Contracts\Queries\ReporteQueryExecutorContract;
use App\Domains\Reporte\Contracts\Enums\ReportStatisticTypeContract;
use App\Domains\Reporte\ValueObjects\ReporteQuery;
use App\Infrastructure\Reporte\Collections\Laravel\Movimientos\LaravelKPICollection;
use App\Infrastructure\Reporte\Queries\Executors\Movimientos\Eloquent\EloquentKPIsQueryExecutor;
use Illuminate\Support\Facades\Cache;

/**
 * Decorador que cachea los KPIs del reporte de movimientos usando Redis.
 *
 * Utiliza la etiqueta 'reportes' para agrupar todas las claves y permitir
 * una invalidación global cuando se escriban movimientos.
 *
 * TTL por defecto: 3600 segundos.
 */
final readonly class CachedKPIsQueryExecutor implements ReporteQueryExecutorContract
{
    private const CACHE_TTL = 3600;

    public function __construct(
        private EloquentKPIsQueryExecutor $executor
    ) {}

    public function supports(ReportStatisticTypeContract $type): bool
    {
        return $this->executor->supports($type);
    }

    public function execute(ReporteQuery $dto): LaravelKPICollection
    {
        $cacheKey = sprintf('reporte_kpis_%s_%s',
            $dto->dateRange->startDate->format('Y-m-d'),
            $dto->dateRange->endDate->format('Y-m-d')
        );

        return Cache::tags(['reportes'])->remember($cacheKey, self::CACHE_TTL, function () use ($dto) {
            return $this->executor->execute($dto);
        });
    }
}
