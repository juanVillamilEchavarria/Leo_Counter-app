<?php

namespace App\Infrastructure\Reporte\Queries\Aggregators\Abstracts;
use App\Domains\Reporte\Contracts\Strategies\ReportGranularityStrategyContract;
/**
 * Clase abstracta para las estrategias de granularidad de los reportes
 * Define la estructura básica que deben seguir las estrategias de granularidad
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 */
abstract class ReportGranularityStrategy implements ReportGranularityStrategyContract{
    /**
     * Limite de dias para los que esta estrategia es aplicable, por ejemplo, la estrategia diaria es aplicable para reportes de hasta 30 días, la mensual para reportes de hasta 365 días, y la anual para reportes de más de 365 días
      * @var int
     */
    protected int $limit ;
    
    abstract public function groupBy(): string;
    public function supports(int $days){
        return $days <= $this->limit;
    }
}