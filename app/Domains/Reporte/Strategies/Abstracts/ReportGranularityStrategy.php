<?php

namespace App\Domains\Reporte\Strategies\Abstracts;

abstract class ReportGranularityStrategy {
    protected int $limit ;
    
    abstract public function groupBy(): string;
    public function supports(int $days){
        return $days <= $this->limit;
    }
}