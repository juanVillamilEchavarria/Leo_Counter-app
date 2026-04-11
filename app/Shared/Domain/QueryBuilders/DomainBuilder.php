<?php

namespace App\Shared\Domain\QueryBuilders;

use Illuminate\Database\Query\Builder as LaravelBuilder;
use Illuminate\Support\Facades\DB;

/**
 * Adapter sobre el Query Builder de infraestructura.
 *
 * @author Juan Villamil
 * @package App\Shared\Domain\QueryBuilders
 * @since 1.0.0
 */
 class DomainQueryBuilder
{
    public function __construct(
        protected LaravelBuilder $builder
    ) {}
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
     * Expone el builder subyacente SOLO para infraestructura.
     * Nunca llamar desde Domain o Application.
     * @internal
     */
    public function toBase(): LaravelBuilder
    {
        return $this->builder;
    }

    public function getJoins(): ?array{
        return $this->builder->joins;

    }
    /**
      * verifica si la query tiene un join a la tabla especificada
      *
      * @param string $table
      * @return bool
      */
     public function hasJoin(string $table): bool {
        if (!$this->getJoins()) {
            return false;
        }
        return collect($this->getJoins())
            ->pluck('table')
            ->contains(function ($joinTable) use ($table) {
                // Normalizar nombres (eliminar alias, espacios, case)
                $normalized = strtolower(trim(explode(' as ', $joinTable)[0]));
                return $normalized === strtolower(trim($table));
            });
    }
}