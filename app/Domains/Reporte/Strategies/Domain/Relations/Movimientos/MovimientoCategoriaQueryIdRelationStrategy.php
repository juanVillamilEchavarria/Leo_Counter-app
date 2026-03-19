<?php

namespace App\Domains\Reporte\Strategies\Domain\Relations\Movimientos;
use App\Domains\Reporte\Strategies\Abstracts\QueryIdRelationStrategy;
use App\Domains\Reporte\Strategies\Contracts\QueryIdRelationStrategyContract;

class MovimientoCategoriaQueryIdRelationStrategy extends QueryIdRelationStrategy implements QueryIdRelationStrategyContract{
    protected string $table = 'movimientos';
    protected string $relationColumn = 'movimientos.categoria_id';
    protected string $dtoProperty = 'categorias';
}