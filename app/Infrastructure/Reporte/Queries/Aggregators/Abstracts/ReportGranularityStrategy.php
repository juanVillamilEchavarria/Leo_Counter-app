<?php

namespace App\Infrastructure\Reporte\Queries\Aggregators\Abstracts;

abstract class ReportGranularityStrategy {
    protected int $limit ;
    
    abstract public function groupBy(): string;
    public function supports(int $days){
        return $days <= $this->limit;
    }
}