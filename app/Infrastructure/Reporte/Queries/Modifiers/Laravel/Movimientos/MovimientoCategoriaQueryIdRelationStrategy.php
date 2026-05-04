<?php

namespace App\Infrastructure\Reporte\Queries\Modifiers\Laravel\Movimientos;

use App\Infrastructure\Reporte\Enums\Queries\Builders\MovimientoQueryRelationParam;
use App\Domains\Reporte\ValueObjects\ReporteQuery;
use App\Infrastructure\Reporte\Queries\Modifiers\Laravel\Abstracts\QueryIdRelationStrategy;
use App\Shared\Domain\ValueObjects\Ids;

final class MovimientoCategoriaQueryIdRelationStrategy extends QueryIdRelationStrategy
{

    protected string $table = MovimientoQueryRelationParam::TABLE->value;
    protected string $relationColumn = 'movimientos.categoria_id';

    protected function dtoProperty(ReporteQuery $reporteQueryDTO): ?Ids
    {
        return $reporteQueryDTO->categorias;
    }
}
