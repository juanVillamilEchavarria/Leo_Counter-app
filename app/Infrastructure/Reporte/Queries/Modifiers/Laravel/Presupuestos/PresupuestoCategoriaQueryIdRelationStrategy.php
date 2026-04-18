<?php

namespace App\Infrastructure\Reporte\Queries\Modifiers\Laravel\Presupuestos;

use App\Infrastructure\Reporte\Enums\Queries\Builders\PresupuestoQueryRelationParam;
use App\Domains\Reporte\ValueObjects\ReporteQuery;
use App\Infrastructure\Reporte\Queries\Modifiers\Laravel\Abstracts\QueryIdRelationStrategy;
use App\Shared\Domain\ValueObjects\Ids;

final class PresupuestoCategoriaQueryIdRelationStrategy extends QueryIdRelationStrategy
{
    public function __construct()
    {
        $this->table = PresupuestoQueryRelationParam::TABLE->value;
        $this->relationColumn = 'presupuestos.categoria_id';
    }

    protected function dtoProperty(ReporteQuery $reporteQueryDTO): ?Ids
    {
        return $reporteQueryDTO->categorias;
    }
}
