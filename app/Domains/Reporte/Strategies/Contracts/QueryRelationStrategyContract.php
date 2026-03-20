<?php

namespace App\Domains\Reporte\Strategies\Contracts;
use Illuminate\Database\Query\Builder;
use App\Domains\Reporte\DTOs\ReporteQueryDTO;
interface QueryRelationStrategyContract{
    public function supports(ReporteQueryDTO $reporteQueryDTO, string $param);
    public function apply(Builder $query, ReporteQueryDTO $reporteQueryDTO);
}