<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Categoria\Contracts\Queries\Executors;

/**
 * Contrato que debe implementar el query executor encargado de obtener el número de registros de categorías.
 * Este executor corresponde a un caso de uso específico de conteo de registros, separado del contrato general de consultas de categorías.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Categoria\Contracts\Queries\Executors
 * @since 1.0.0
 * @version 1.0.0
 */
interface GetCategoriaRecordsCountQueryExecutorContract
{
    /**
     * Ejecuta la consulta para obtener el número total de categorías.
     * @return int
     */
    public function execute(): int;
}
