<?php

namespace App\Shared\Contracts\Queries\Executors;

use App\Shared\Application\DTOs\PaginatedTableResultDTO;
use App\Shared\Application\Queries\TableQuery;

/**
 * Contrato para el executor de paginación de tablas.
 * cada modulo en la capa de aplicacion, debe implementar su propio contrato que extienda a este.
 * @author JuanVillamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
interface PaginatedTableQueryExecutorContract{
    /**
     * Ejecuta el query de paginación de tablas.
     * devuelve un DTO que contiene los items y la meta data de la paginación.
     * @return PaginatedTableResultDTO
     */
    public function execute(TableQuery $query): PaginatedTableResultDTO;
}