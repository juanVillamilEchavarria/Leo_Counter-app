<?php

namespace App\Domains\Reporte\Strategies\Resolvers\Relations;

use Illuminate\Database\Query\Builder;
use App\Domains\Reporte\DTOs\ReporteQueryDTO;

 class QueryRelationResolver{
      public function __construct(
        /**
         * @var iterable<QueryRelationStrategyContract>
         */
        private iterable $strategies
    )
    {
    }
        public function resolve(Builder $query, ReporteQueryDTO $reporteQueryDTO, string $param){
        foreach($this->strategies as $strategy){
            if($strategy->supports($reporteQueryDTO, $param)){
                $query = $strategy->apply($query, $reporteQueryDTO);
            }
        }
        return $query;
    }

}