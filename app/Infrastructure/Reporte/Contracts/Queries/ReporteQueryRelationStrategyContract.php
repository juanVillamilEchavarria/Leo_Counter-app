<?php

namespace App\Infrastructure\Reporte\Contracts\Queries;

use App\Infrastructure\Reporte\Contracts\Enums\QueryRelationParamContract;
use App\Domains\Reporte\ValueObjects\ReporteQuery;
use Illuminate\Database\Query\Builder;

interface ReporteQueryRelationStrategyContract
{
    public function supports(ReporteQuery $dto, QueryRelationParamContract $param): bool;
    public function apply(Builder $query, ReporteQuery $dto): Builder;
}
