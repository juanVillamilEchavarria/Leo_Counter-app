<?php

namespace App\Shared\Infrastructure\QueryBuilders;

use Illuminate\Database\Query\Builder as LaravelBuilder;

/**
 * Adaptador de infraestructura sobre el Query Builder de Laravel.
 * Encapsula las operaciones utilizadas por los query handlers Eloquent
 * del módulo de reportes.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Shared\Infrastructure\QueryBuilders
 * @since 1.0.0
 * @version 1.0.0
 */
final class DomainQueryBuilder
{
    public function __construct(
        private LaravelBuilder $builder
    ) {
    }

    public function whereBetween(string $column, array $values): static
    {
        $this->builder->whereBetween($column, $values);

        return $this;
    }

    public function whereIn(string $column, array $values): static
    {
        $this->builder->whereIn($column, $values);

        return $this;
    }

    public function where(string $column, mixed $operator, mixed $value = null, string $boolean = 'and'): static
    {
        $this->builder->where($column, $operator, $value, $boolean);

        return $this;
    }

    public function join(string $table, string $first, string $operator, string $second): static
    {
        $this->builder->join($table, $first, $operator, $second);

        return $this;
    }

    public function selectRaw(string $expression, array $bindings = []): static
    {
        $this->builder->selectRaw($expression, $bindings);

        return $this;
    }

    public function groupByRaw(string $expression): static
    {
        $this->builder->groupByRaw($expression);

        return $this;
    }

    public function groupBy(string ...$columns): static
    {
        $this->builder->groupBy(...$columns);

        return $this;
    }

    public function orderBy(string $column, string $direction = 'asc'): static
    {
        $this->builder->orderBy($column, $direction);

        return $this;
    }

    public function orderByDesc(string $column): static
    {
        $this->builder->orderByDesc($column);

        return $this;
    }

    public function sum(string $column): float
    {
        return (float) $this->builder->sum($column);
    }

    public function get(): iterable
    {
        return $this->builder->get();
    }

    /**
     * Expone el builder subyacente únicamente para uso interno de infraestructura.
     *
     * @return LaravelBuilder
     */
    public function toBase(): LaravelBuilder
    {
        return $this->builder;
    }

    /**
     * Retorna los joins registrados actualmente en la consulta.
     *
     * @return array<int, object>
     */
    public function getJoins(): array
    {
        return $this->builder->joins ?? [];
    }

    /**
     * Determina si la consulta ya contiene un join hacia la tabla indicada.
     *
     * @param string $table
     * @return bool
     */
    public function hasJoin(string $table): bool
    {
        foreach ($this->getJoins() as $join) {
            $joinTable = is_string($join->table ?? null) ? $join->table : '';
            $normalized = strtolower(trim(explode(' as ', $joinTable)[0]));

            if ($normalized === strtolower(trim($table))) {
                return true;
            }
        }

        return false;
    }
}
