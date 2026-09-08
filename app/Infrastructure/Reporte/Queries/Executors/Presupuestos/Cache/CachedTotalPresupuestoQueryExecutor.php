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
use App\Infrastructure\Reporte\Queries\Executors\Abstracts\Cache\CacheReportQueryExecutor;
use App\Infrastructure\Reporte\Queries\Executors\Presupuestos\Eloquent\EloquentTotalPresupuestoQueryExecutor;
use Override;

/**
 * Decorador que cachea el total de presupuesto en un periodo.
 */
final readonly class CachedTotalPresupuestoQueryExecutor extends CacheReportQueryExecutor implements ReporteQueryExecutorContract
{

    public function __construct(
         EloquentTotalPresupuestoQueryExecutor $executor
    ) {
        parent::__construct($executor);
    }

   #[Override]
   protected function getCacheKeyPrefix(): string
   {
       return 'total_presupuesto';
   }
}
