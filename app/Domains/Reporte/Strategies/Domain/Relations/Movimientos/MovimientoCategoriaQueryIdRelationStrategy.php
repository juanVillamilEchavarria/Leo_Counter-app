<?php

namespace App\Domains\Reporte\Strategies\Domain\Relations\Movimientos;

use App\Domains\Reporte\DTOs\ReporteQueryDTO;
use App\Domains\Reporte\Strategies\Abstracts\QueryIdRelationStrategy;
use App\Domains\Reporte\Strategies\Contracts\QueryRelationStrategyContract;
use App\Domains\Reporte\Strategies\Enums\QueryRelationParam;
use App\Shared\DTOs\Querys\IdsDTO;

class MovimientoCategoriaQueryIdRelationStrategy extends QueryIdRelationStrategy implements QueryRelationStrategyContract{
    protected string $table = QueryRelationParam::MOVIMIENTOS_TABLE->value;
    protected string $relationColumn = 'movimientos.categoria_id';
    protected function dtoProperty(ReporteQueryDTO $reporteQueryDTO): IdsDTO | null
    {
        return $reporteQueryDTO->categorias;
    }
}