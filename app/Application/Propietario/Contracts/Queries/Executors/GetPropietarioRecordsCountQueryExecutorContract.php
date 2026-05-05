<?php

namespace App\Application\Propietario\Contracts\Queries\Executors;

/**
 * Contrato que debe implementar el query executor encargado de obtener el numero de registros de propietarios.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Propietario\Contracts\Queries\Executors
 * @since 1.0.0
 * @version 1.0.0
 */
interface GetPropietarioRecordsCountQueryExecutorContract{

    /**
     * Ejecuta el query para obtener el numero de registros de propietarios
     * @return int
     */
    public function execute(): int;
}