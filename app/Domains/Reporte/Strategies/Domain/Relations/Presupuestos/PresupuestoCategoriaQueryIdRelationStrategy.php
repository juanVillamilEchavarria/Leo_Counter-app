<?php

namespace App\Domains\Reporte\Strategies\Domain\Relations\Presupuestos;

use App\Domains\Reporte\ValueObjects\ReporteQueryDTO;
use App\Domains\Reporte\Strategies\Abstracts\QueryIdRelationStrategy;
use App\Domains\Reporte\Contracts\Strategies\QueryRelationStrategyContract;
use App\Domains\Reporte\Enums\PresupuestoQueryRelationParam;
use App\Shared\DTOs\Querys\IdsDTO;

class PresupuestoCategoriaQueryIdRelationStrategy extends QueryIdRelationStrategy implements QueryRelationStrategyContract {
    public function __construct() {
        $this->table = PresupuestoQueryRelationParam::TABLE->value;
        $this->relationColumn = 'presupuestos.categoria_id';
    }

    protected function dtoProperty(ReporteQueryDTO $reporteQueryDTO): IdsDTO | null
    {
        return $reporteQueryDTO->categorias;
    }
}