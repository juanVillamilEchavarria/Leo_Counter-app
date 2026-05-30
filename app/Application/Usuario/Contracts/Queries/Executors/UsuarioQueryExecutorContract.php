<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Usuario\Contracts\Queries\Executors;

use App\Shared\Domain\Contracts\CollectionContract;

/**
 * Contrato para los executors de consultas de usuarios.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Usuario\Contracts\Queries\Executors
 * @since 1.0.0
 * @version 1.0.0
 */
interface UsuarioQueryExecutorContract
{
    /**
     * Ejecuta la consulta de listado de usuarios.
     *
     * @return CollectionContract Colección de usuarios encontrados.
     */
    public function execute(): CollectionContract;
}
