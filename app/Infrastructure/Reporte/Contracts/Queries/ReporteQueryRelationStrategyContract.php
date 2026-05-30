<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Infrastructure\Reporte\Contracts\Queries;

use App\Infrastructure\Reporte\Contracts\Enums\QueryRelationParamContract;
use App\Domains\Reporte\ValueObjects\ReporteQuery;
use Illuminate\Database\Query\Builder;

interface ReporteQueryRelationStrategyContract
{
    public function supports(ReporteQuery $dto, QueryRelationParamContract $param): bool;
    public function apply(Builder $query, ReporteQuery $dto): Builder;
}
