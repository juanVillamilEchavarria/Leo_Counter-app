<?php
namespace App\Application\Propietario\Contracts\Queries\Executors;

use App\Application\Propietario\DTOs\PropietarioShowDTO;
use App\Application\Propietario\Queries\GetPropietarioForShowQuery;

/**
 * Contrato que debe implementar el query executor encargado de obtener un propietario por su id, trayendo informacion detallada de este.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Propietario\Contracts\Queries\Executors
 * @since 1.0.0
 * @version 1.0.0
 */
interface PropietarioShowQueryExecutorContract
{
    /**
     * Ejecuta el query para obtener un propietario por su id, trayendo informacion detallada de este.
     * @return PropietarioShowDTO
     */
    public function execute(GetPropietarioForShowQuery $query): PropietarioShowDTO;
}