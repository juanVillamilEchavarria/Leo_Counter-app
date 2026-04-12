<?php

namespace App\Infrastructure\Reporte\Strategies\Relations\Presupuestos;

use App\Infrastructure\Reporte\Enums\Queries\Builders\PresupuestoQueryRelationParam;
use App\Domains\Reporte\ValueObjects\ReporteQueryDTO;
use App\Infrastructure\Reporte\Strategies\Relations\Abstracts\QueryIdRelationStrategy;
use App\Shared\DTOs\Querys\IdsDTO;

final class PresupuestoCategoriaQueryIdRelationStrategy extends QueryIdRelationStrategy
{
    public function __construct()
    {
        $this->table = PresupuestoQueryRelationParam::TABLE->value;
        $this->relationColumn = 'presupuestos.categoria_id';
    }

    protected function dtoProperty(ReporteQueryDTO $reporteQueryDTO): ?IdsDTO
    {
        return $reporteQueryDTO->categorias;
    }
}
