<?php

namespace App\Domains\Reporte\ValueObjects;

use App\Domains\Reporte\Contracts\Enums\ReportStatisticTypeContract;

/**
 * Value Object inmutable que encapsula los resultados de una consulta de reportes.
 * Almacena tanto los resultados principales como, opcionalmente, los resultados
 * del periodo anterior para métricas comparativas.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Reporte\ValueObjects
 * @since 1.0.0
 */
final class ReporteQueryResult
{
    /** @var array<string, mixed> */
    private array $results = [];

    /**
     * Almacena los resultados del periodo anterior indexados por tipo.
     *
     * @var array<string, mixed>
     */
    private array $previousResults = [];

    public function add(ReportStatisticTypeContract $type, mixed $collection): self
    {
        $clone = clone $this;
        $clone->results[$type->value] = $collection;

        return $clone;
    }

    /**
     * Obtiene el resultado principal asociado al tipo indicado.
     *
     * @param ReportStatisticTypeContract $type
     * @return mixed
     * @throws \InvalidArgumentException Cuando no existe resultado para el tipo solicitado.
     */
    public function get(ReportStatisticTypeContract $type): mixed
    {
        if (!isset($this->results[$type->value])) {
            throw new \InvalidArgumentException("No result for type: {$type->value}");
        }

        return $this->results[$type->value];
    }

    public function has(ReportStatisticTypeContract $type): bool
    {
        return isset($this->results[$type->value]);
    }

    /**
     * Agrega una colección del periodo anterior al resultado.
     *
     * @param ReportStatisticTypeContract $type
     * @param mixed $collection
     * @return self
     */
    public function addPrevious(ReportStatisticTypeContract $type, mixed $collection): self
    {
        $clone = clone $this;
        $clone->previousResults[$type->value] = $collection;

        return $clone;
    }

    /**
     * Obtiene la colección del periodo anterior para un tipo dado.
     * Retorna null si el tipo no requiere datos comparativos.
     *
     * @param ReportStatisticTypeContract $type
     * @return mixed
     */
    public function getPrevious(ReportStatisticTypeContract $type): mixed
    {
        return $this->previousResults[$type->value] ?? null;
    }

    /**
     * Determina si existe un resultado del periodo anterior para el tipo indicado.
     *
     * @param ReportStatisticTypeContract $type
     * @return bool
     */
    public function hasPrevious(ReportStatisticTypeContract $type): bool
    {
        return isset($this->previousResults[$type->value]);
    }

    /**
     * Combina este resultado con otro, uniendo ambos conjuntos de datos.
     * Los datos del resultado entrante tienen precedencia en caso de colisión.
     *
     * @param self $other
     * @return self
     */
    public function merge(self $other): self
    {
        $clone = clone $this;

        foreach ($other->results as $key => $collection) {
            $clone->results[$key] = $collection;
        }

        foreach ($other->previousResults as $key => $collection) {
            $clone->previousResults[$key] = $collection;
        }

        return $clone;
    }
}
