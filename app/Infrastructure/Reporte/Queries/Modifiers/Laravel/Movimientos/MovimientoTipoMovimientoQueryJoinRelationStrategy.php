<?php

namespace App\Infrastructure\Reporte\Queries\Modifiers\Laravel\Movimientos;

use App\Infrastructure\Reporte\Enums\Queries\Builders\MovimientoQueryRelationParam;
use App\Domains\Reporte\ValueObjects\ReporteQuery;
use App\Infrastructure\Reporte\Queries\Modifiers\Laravel\Abstracts\QueryJoinRelationStrategy;
use App\Infrastructure\Reporte\Contracts\Enums\QueryRelationParamContract;
use App\Shared\Enums\ComparativeOperators;

final class MovimientoTipoMovimientoQueryJoinRelationStrategy extends QueryJoinRelationStrategy
{
    public function __construct()
    {
        $this->table = MovimientoQueryRelationParam::TABLE->value;
        $this->relationTable = 'tipo_movimientos';
        $this->relationColumn = 'movimientos.tipo_movimiento_id';
        $this->comparativeColumn = 'tipo_movimientos.id';
        $this->joinOperator = ComparativeOperators::EQUALS;
    }

    protected function dtoProperty(ReporteQuery $reporteQueryDTO): mixed
    {
        return null;
    }

    public function supports(ReporteQuery $reporteQueryDTO, QueryRelationParamContract $param): bool
    {
        return $param->value === MovimientoQueryRelationParam::TIPO_MOVIMIENTOS_JOIN->value;
    }
}
