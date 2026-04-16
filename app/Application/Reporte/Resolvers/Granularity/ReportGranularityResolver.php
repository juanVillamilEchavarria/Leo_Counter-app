<?php
namespace App\Application\Reporte\Resolvers\Granularity;
use App\Domains\Reporte\Contracts\Strategies\ReportGranularityStrategyContract;
use App\Application\Reporte\Exceptions\CannotResolveGranualityException;

class ReportGranularityResolver{
    public function __construct(
        /**
         * @var ReportGranularityStrategyContract[]
         */
        private iterable $strategies
    )
    {
    }

    public function resolve(int $days) : ReportGranularityStrategyContract{
        foreach ($this->strategies as $strategy) {
                if ($strategy->supports($days)) {

                    return $strategy;
                }
            }
            throw new CannotResolveGranualityException('No se pudo resolver la granularidad del reporte');
    }
    
}