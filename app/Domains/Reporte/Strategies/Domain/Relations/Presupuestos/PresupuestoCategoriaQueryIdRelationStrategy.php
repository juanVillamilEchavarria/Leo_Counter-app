<?php

namespace App\Domains\Reporte\Strategies\Domain\Relations\Presupuestos;

use App\Domains\Reporte\Strategies\Abstracts\QueryIdRelationStrategy;
use App\Domains\Reporte\Strategies\Contracts\QueryIdRelationStrategyContract;

class PresupuestoCategoriaQueryIdRelationStrategy extends QueryIdRelationStrategy implements QueryIdRelationStrategyContract {
    protected string $table = 'presupuestos';
    protected string $dtoProperty = 'categorias';
    protected string $relationColumn = 'presupuestos.categoria_id';
}