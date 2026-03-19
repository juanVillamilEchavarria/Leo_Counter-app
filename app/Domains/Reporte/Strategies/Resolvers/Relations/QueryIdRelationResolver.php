<?php

namespace App\Domains\Reporte\Strategies\Resolvers\Relations;

use Illuminate\Database\Query\Builder;
use App\Domains\Reporte\DTOs\ReporteQueryDTO;

 class QueryIdRelationResolver{
      public function __construct(
        /**
         * @var iterable<QueryIdRelationStrategyContract>
         */
        private iterable $strategies
    )
    {
    }
        public function resolve(Builder $query, ReporteQueryDTO $reporteQueryDTO, string $table){
        foreach($this->strategies as $strategy){
            if($strategy->supports($reporteQueryDTO, $table)){
                $query = $strategy->apply($query, $reporteQueryDTO);
            }
        }
        return $query;
    }

}