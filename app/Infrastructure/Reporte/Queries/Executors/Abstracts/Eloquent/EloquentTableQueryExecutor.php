<?php
namespace App\Infrastructure\Reporte\Queries\Executors\Abstracts\Eloquent;
use App\Shared\Infrastructure\Queries\Builders\ConditionalAggregateBuilder;
use DateTimeImmutable;
use Illuminate\Database\Query\Builder;

abstract class EloquentTableQueryExecutor
{

    /**
     * Aplica la filtracion por fecha (periodo) a la consulta
     * @param DateTimeImmutable $startDate Fecha de inicio del periodo
     * @param DateTimeImmutable $endDate Fecha de fin del periodo
     * @param Builder $query Consulta a la que se le aplicara el filtro
     * @param string $column Columna de fecha a la que se le aplicara el filtro por periodo
     */
    protected function baseQuery(
        DateTimeImmutable $startDate,
        DateTimeImmutable $endDate,
        Builder $query,
        string $column
    ): Builder {
        return $query->whereBetween($column, [$startDate, $endDate]);
    }
    /**
     * COALESCE(SUM(column), 0)
     * Sin condicionales- suma todos los montos
     * @param string $column Columna a sumar, por defecto 'monto'
     * @return string Consulta SQL para la suma con COALESCE
     */
    protected function getSumQuery(string $column = 'monto'): string
    {
        return ConditionalAggregateBuilder::make()
            ->aggregate('SUM')
            ->column($column)
            ->useCoalesce(true)
            ->build();
    }

     /**
     * Cuenta los registros de la tabla
     * equivalente SQL: COALESCE(COUNT(column), 0)
     * @param string $column Columna a contar, por defecto 'id'
     * @return string Consulta SQL para el conteo con COALESCE
     */
    protected function getTableRecordsCountQuery(
        string $column = 'id'
    ): string
    {
        return ConditionalAggregateBuilder::make()
            ->aggregate('COUNT')
            ->column($column)
            ->useCoalesce(false)
            ->build();
    }
}
