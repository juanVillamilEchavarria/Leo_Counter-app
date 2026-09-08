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
use App\Infrastructure\Reporte\Queries\Executors\Abstracts\Cache\CacheReportQueryExecutor;
use App\Infrastructure\Reporte\Queries\Executors\Movimientos\Eloquent\EloquentKPIsQueryExecutor;
use Override;

/**
 * Decorador que cachea los KPIs del reporte de movimientos usando Redis.
 *
 * Utiliza la etiqueta 'reportes' para agrupar todas las claves y permitir
 * una invalidación global cuando se escriban movimientos.
 *
 * TTL por defecto: 3600 segundos.
 */
final readonly class CachedKPIsQueryExecutor extends CacheReportQueryExecutor implements ReporteQueryExecutorContract
{

    public function __construct(
         EloquentKPIsQueryExecutor $executor
    ) {
        parent::__construct($executor);
    }

   #[Override]
   protected function getCacheKeyPrefix(): string
   {
    return 'kpis';
   }
}
