<?php

namespace App\Domains\Categoria\Contracts;

/**
 * Contrato que define la interfaz para verificar la unicidad de una categoría basada en su nombre y tipo de movimiento.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Categoria\Contracts
 * @since 1.0.0
 * @version 1.0.0
 */
interface CategoriaUniquenessCheckerContract
{
    /**
     * Verifica si ya existe una categoría con el mismo nombre y tipo de movimiento.
     */
    public function exists(string $nombre, int $tipoMovimientoId, ?int $excludeId = null): bool;
}