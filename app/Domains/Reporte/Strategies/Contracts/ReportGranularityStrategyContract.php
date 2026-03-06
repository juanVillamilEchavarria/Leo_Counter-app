<?php

namespace App\Domains\Reporte\Strategies\Contracts;

interface ReportGranularityStrategyContract
{
    public function supports(int $days);
    public function groupBy(): string;
}