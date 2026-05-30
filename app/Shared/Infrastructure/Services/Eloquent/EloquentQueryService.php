<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Shared\Infrastructure\Services\Eloquent;

use Illuminate\Database\Query\Builder;

/**
 * Servicio para obtener informacion de consultas de Eloquent
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final class EloquentQueryService
{
    /**
     * Verifica si una consulta tiene un join a una tabla especifica
     * 
     * @param Builder $query
     * @param string $table
     * @return bool
     */
    public function hasJoin(Builder $query, string $table): bool
    {
        $target = $this->normalizeTable($table);

        foreach ($this->getJoins($query) as $join) {
            $joinTable = $this->extractTableName($join->table ?? '');

            if ($this->normalizeTable($joinTable) === $target) {
                return true;
            }
        }

        return false;
    }

    /**
     * Obtiene los joins de una consulta
     * 
     * @param Builder $query
     * @return array
     */
    private function getJoins(Builder $query): array
    {
        return $query->joins ?? [];
    }

    /**
     * Extrae el nombre de la tabla de un join
     * 
     * @param string $table
     * @return string
     */
    private function extractTableName(string $table): string
    {
        // Maneja "users as u", "users u", etc.
        $table = strtolower(trim($table));

        // elimina alias con "as"
        if (str_contains($table, ' as ')) {
            return explode(' as ', $table)[0];
        }

        // elimina alias sin "as" (ej: "users u")
        return explode(' ', $table)[0];
    }

    /**
     * Normaliza el nombre de una tabla, limpiando espacios y convirtiendo a minusculas
     * 
     * @param string $table
     * @return string
     */
    private function normalizeTable(string $table): string
    {
        return strtolower(trim($table));
    }
}