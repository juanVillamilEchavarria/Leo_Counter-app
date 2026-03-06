<?php

namespace App\Domains\Reporte\Strategies\Abstracts;

abstract class ReportGranularityStrategy {
    public int $limit ;
    
    abstract public function groupBy(): string;
    public function supports(int $days){
        return $days <= $this->limit;
    }
}