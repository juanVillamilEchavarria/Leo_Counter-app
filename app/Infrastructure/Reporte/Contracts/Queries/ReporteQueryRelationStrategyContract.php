<?php

namespace App\Infrastructure\Reporte\Contracts\Queries;

use App\Infrastructure\Reporte\Contracts\Enums\QueryRelationParamContract;
use App\Domains\Reporte\ValueObjects\ReporteQueryDTO;
use Illuminate\Database\Query\Builder;

interface ReporteQueryRelationStrategyContract
{
    public function supports(ReporteQueryDTO $dto, QueryRelationParamContract $param): bool;
    public function apply(Builder $query, ReporteQueryDTO $dto): Builder;
}
