<?php

namespace App\Domains\Reporte\ValueObjects;

use App\Shared\Domain\Contracts\Reporte\ReporteQueryTypeContract;
use App\Shared\Domain\Collections\DomainCollection;

final class ReporteQueryResult
{
    private array $results = [];

    public function add(ReporteQueryTypeContract $type, mixed $collection): self
    {
        $clone = clone $this;
        $clone->results[$type->value] = $collection;

        return $clone;
    }

    public function get(ReporteQueryTypeContract $type): mixed
    {
        if (!isset($this->results[$type->value])) {
            throw new \InvalidArgumentException("No result for type: {$type->value}");
        }

        return $this->results[$type->value];
    }

    public function has(ReporteQueryTypeContract $type): bool
    {
        return isset($this->results[$type->value]);
    }
}
