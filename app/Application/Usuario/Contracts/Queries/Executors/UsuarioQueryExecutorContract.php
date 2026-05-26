<?php

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
