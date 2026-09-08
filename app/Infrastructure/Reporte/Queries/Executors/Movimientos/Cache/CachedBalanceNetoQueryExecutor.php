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
use App\Infrastructure\Reporte\Queries\Executors\Movimientos\Eloquent\EloquentBalanceNetoQueryExecutor;
use App\Infrastructure\Reporte\Queries\Executors\Abstracts\Cache\CacheReportQueryExecutor;
use Override;

/**
 * Decorador que cachea el reporte de balance neto.
 */
final readonly class CachedBalanceNetoQueryExecutor extends CacheReportQueryExecutor implements ReporteQueryExecutorContract
{

    public function __construct(
         EloquentBalanceNetoQueryExecutor $executor
    ) {
        parent::__construct($executor);
    }

    #[Override]
    protected function getCacheKeyPrefix(): string
    {
        return 'balance_neto';
    }

    
}
