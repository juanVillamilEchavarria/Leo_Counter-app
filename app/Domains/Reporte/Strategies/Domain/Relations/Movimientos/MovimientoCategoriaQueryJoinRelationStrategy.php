<?php

namespace App\Domains\Reporte\Strategies\Domain\Relations\Movimientos;

use App\Domains\Reporte\Strategies\Abstracts\QueryJoinRelationStrategy;
use App\Domains\Reporte\Contracts\Strategies\QueryRelationStrategyContract;
use App\Domains\Reporte\ValueObjects\ReporteQueryDTO;
use App\Shared\Enums\ComparativeOperators;
use App\Domains\Reporte\Enums\MovimientoQueryRelationParam;

class MovimientoCategoriaQueryJoinRelationStrategy extends QueryJoinRelationStrategy implements QueryRelationStrategyContract{
    public function __construct() {
        $this->table = MovimientoQueryRelationParam::TABLE->value;
        $this->relationTable = 'categorias';
        $this->relationColumn = 'movimientos.categoria_id';
        $this->comparativeColumn = 'categorias.id';
        $this->joinOperator = ComparativeOperators::EQUALS;
    }

    protected function dtoProperty(ReporteQueryDTO $reporteQueryDTO): mixed{
        return null;
    }
    public function supports(ReporteQueryDTO $reporteQueryDTO, \App\Shared\Domain\Contracts\Reporte\QueryRelationParamContract $param)
    {
        /**
         * en este caso, se va a comparar con la tabla de la relacion, ya que movimientos tiene varios strategies
         */
        return $param->value === MovimientoQueryRelationParam::CATEGORIAS_JOIN->value;
    }
}