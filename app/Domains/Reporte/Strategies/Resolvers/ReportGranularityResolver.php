<?php
namespace App\Domains\Reporte\Strategies\Resolvers;

use App\Domains\Reporte\Strategies\Contracts\ReportGranularityStrategyContract;
use App\Domains\Reporte\Exception\CannotResolveGranualityException;

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
            throw new CannotResolveGranualityException('No granularity strategy found');
    }
    
}