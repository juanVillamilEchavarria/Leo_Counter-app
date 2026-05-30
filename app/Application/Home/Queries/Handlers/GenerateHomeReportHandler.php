<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Home\Queries\Handlers;

use App\Application\Reporte\Queries\GenerateFinancialReportQuery;
use App\Application\Home\Enums\HomeStatisticsType;
use App\Application\Reporte\Handlers\GenerateReportHandler;
use App\Domains\Reporte\ValueObjects\ReporteQueryResult;
use DateTimeImmutable;

/**
 * Handler encargado de generarel reporte de home.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Home\Queries
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class GenerateHomeReportHandler{
    public function __construct(
        private GenerateReportHandler $reportHandler
    )
    {
    }
    /**
     * Genera el reporte.
     * @return ReporteQueryResult
     */
    public function __invoke() : ReporteQueryResult
    {
        $query = new GenerateFinancialReportQuery(
            startDate: new DateTimeImmutable('-1 month')->format('Y-m-d'),
            endDate: new DateTimeImmutable()->format('Y-m-d'),
        );
        return $this->reportHandler->__invoke(HomeStatisticsType::statistics(),$query);

    }
}