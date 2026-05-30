<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Propietario\Contracts\Queries\Executors;

use App\Application\Propietario\Contracts\Queries\ListPropietariosQueryContract;
use App\Shared\Domain\Contracts\CollectionContract;

/**
 * Contrato para los executors de queries de propietarios.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Propietario\Contracts\Queries\Executors
 * @since 1.0.0
 * @version 1.0.0
 */
interface PropietarioQueryExecutorContract
{
    /**
     * Ejecuta el query de propietarios y devuelve una colección de propietarios.
     * @param ListPropietariosQueryContract $query
     * @return CollectionContract
     */
    public function execute(ListPropietariosQueryContract $query): CollectionContract;
}
