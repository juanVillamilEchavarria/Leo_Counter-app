<?php
/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Infrastructure\Reporte\Queries\Executors\Abstracts\Cache;


use App\Application\Reporte\Contracts\Queries\ReporteQueryExecutorContract;
use App\Domains\Reporte\Contracts\Enums\ReportStatisticTypeContract;
use App\Domains\Reporte\ValueObjects\ReporteQuery;
use App\Infrastructure\Reporte\Builders\CacheKeyBuilderForReport;
use Illuminate\Support\Facades\Cache;

abstract readonly class CacheReportQueryExecutor implements ReporteQueryExecutorContract
{
    private const CACHE_TTL = 3600;

    public function __construct(
        private ReporteQueryExecutorContract $executor
    ) {}

    public function supports(ReportStatisticTypeContract $type): bool
    {
        return $this->executor->supports($type);
    }

    abstract protected function getCacheKeyPrefix(): string;

    /**
     * Este metodo puede ser sobrescrito por las clases hijas para personalizar la funcion de cacheo
     * @param ReporteQuery $dto
     * @return mixed
     */
    protected function cacheFunction(ReporteQuery $dto): mixed
    {
        return $this->executor->execute($dto);
    }

    public function execute(ReporteQuery $dto): mixed
    {
        $cacheKey = CacheKeyBuilderForReport::build($this->getCacheKeyPrefix(), $dto);

        return Cache::tags(['reportes'])->remember($cacheKey, self::CACHE_TTL, function () use ($dto) {
            return $this->cacheFunction($dto);
        });
    }
}