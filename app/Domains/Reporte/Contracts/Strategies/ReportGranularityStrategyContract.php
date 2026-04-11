<?php

namespace App\Domains\Reporte\Contracts\Strategies;

interface ReportGranularityStrategyContract
{
    public function supports(int $days);
    public function groupBy(): string;
}