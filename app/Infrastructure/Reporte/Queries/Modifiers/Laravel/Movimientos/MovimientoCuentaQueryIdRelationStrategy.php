<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Infrastructure\Reporte\Queries\Modifiers\Laravel\Movimientos;

use App\Infrastructure\Reporte\Enums\Queries\Builders\MovimientoQueryRelationParam;
use App\Domains\Reporte\ValueObjects\ReporteQuery;
use App\Infrastructure\Reporte\Queries\Modifiers\Laravel\Abstracts\QueryIdRelationStrategy;
use App\Shared\Domain\ValueObjects\Ids;

final class MovimientoCuentaQueryIdRelationStrategy extends QueryIdRelationStrategy
{
     protected string $table = MovimientoQueryRelationParam::TABLE->value;
        protected string $relationColumn = 'movimientos.cuenta_id';

    protected function dtoProperty(ReporteQuery $reporteQueryDTO): ?Ids
    {
        return $reporteQueryDTO->cuentas;
    }
}
