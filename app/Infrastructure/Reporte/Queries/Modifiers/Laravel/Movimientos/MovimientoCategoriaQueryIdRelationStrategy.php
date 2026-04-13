<?php

namespace App\Infrastructure\Reporte\Queries\Modifiers\Laravel\Movimientos;

use App\Infrastructure\Reporte\Enums\Queries\Builders\MovimientoQueryRelationParam;
use App\Domains\Reporte\ValueObjects\ReporteQueryDTO;
use App\Infrastructure\Reporte\Queries\Modifiers\Laravel\Abstracts\QueryIdRelationStrategy;
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
