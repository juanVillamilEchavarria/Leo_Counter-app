<?php

namespace App\Domains\Reporte\Strategies\Domain\Relations\Movimientos;

use App\Domains\Reporte\ValueObjects\ReporteQueryDTO;
use App\Domains\Reporte\Strategies\Abstracts\QueryIdRelationStrategy;
use App\Domains\Reporte\Contracts\Strategies\QueryRelationStrategyContract;
use App\Domains\Reporte\Enums\MovimientoQueryRelationParam;
use App\Shared\DTOs\Querys\IdsDTO;

class MovimientoCategoriaQueryIdRelationStrategy extends QueryIdRelationStrategy implements QueryRelationStrategyContract{
    public function __construct() {
        $this->table = MovimientoQueryRelationParam::TABLE->value;
        $this->relationColumn = 'movimientos.categoria_id';
    }
    protected function dtoProperty(ReporteQueryDTO $reporteQueryDTO): IdsDTO | null
    {
        return $reporteQueryDTO->categorias;
    }
}