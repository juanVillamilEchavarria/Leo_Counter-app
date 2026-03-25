<?php

namespace App\Domains\Reporte\Strategies\Resolvers\Relations;

use Illuminate\Database\Query\Builder;
use App\Domains\Reporte\DTOs\ReporteQueryDTO;
use App\Domains\Reporte\Strategies\Enums\QueryRelationParam;

 class QueryRelationResolver{
      public function __construct(
        /**
         * @var iterable<QueryRelationStrategyContract>
         */
        private iterable $strategies
    )
    {
    }
        public function resolve(Builder $query, ReporteQueryDTO $reporteQueryDTO, QueryRelationParam $param){
        foreach($this->strategies as $strategy){
            if($strategy->supports($reporteQueryDTO, $param)){
                $query = $strategy->apply($query, $reporteQueryDTO);
            }
        }
        return $query;
    }

}