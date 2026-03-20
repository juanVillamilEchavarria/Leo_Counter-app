<?php

namespace App\Domains\Reporte\Strategies\Domain\Relations\Movimientos;

use App\Domains\Reporte\Strategies\Abstracts\QueryJoinRelationStrategy;
use App\Domains\Reporte\Strategies\Contracts\QueryRelationStrategyContract;
use App\Domains\Reporte\DTOs\ReporteQueryDTO;
use App\Shared\Enums\ComparativeOperators;
class MovimientoTipoMovimientoQueryJoinRelationStrategy extends QueryJoinRelationStrategy implements QueryRelationStrategyContract{
    protected string $table = 'movimientos';
    protected string $relationTable = 'tipo_movimientos';
    protected string $relationColumn = 'movimientos.tipo_movimiento_id';
    protected string $comparativeColumn = 'tipo_movimientos.id';
    protected ComparativeOperators $joinOperator = ComparativeOperators::EQUALS;

    public function supports(ReporteQueryDTO $reporteQueryDTO, string $param)
    {
        /**
         * en este caso, se va a comparar con la tabla de la relacion, ya que movimientos tiene varios strategies
         */
        return $param === 'tipo_movimientos_join';
    }
}