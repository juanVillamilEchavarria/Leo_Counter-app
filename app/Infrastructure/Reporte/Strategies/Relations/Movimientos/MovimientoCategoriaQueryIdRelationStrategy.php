<?php

namespace App\Infrastructure\Reporte\Strategies\Relations\Movimientos;

use App\Infrastructure\Reporte\Enums\Queries\Builders\MovimientoQueryRelationParam;
use App\Domains\Reporte\ValueObjects\ReporteQueryDTO;
use App\Infrastructure\Reporte\Strategies\Relations\Abstracts\QueryIdRelationStrategy;
use App\Shared\DTOs\Querys\IdsDTO;

final class MovimientoCategoriaQueryIdRelationStrategy extends QueryIdRelationStrategy
{
    public function __construct()
    {
        $this->table = MovimientoQueryRelationParam::TABLE->value;
        $this->relationColumn = 'movimientos.categoria_id';
    }

    protected function dtoProperty(ReporteQueryDTO $reporteQueryDTO): ?IdsDTO
    {
        return $reporteQueryDTO->categorias;
    }
}
