<?php

namespace App\Shared\Application\Contracts\Bus;
use App\Shared\Application\Contracts\Queries\QueryContract;

/**
 * Contrato para el QueryBus, que es responsable de manejar la ejecución de queries en la aplicación.
 * El QueryBus recibe un query (que debe implementar el contrato QueryContract) y devuelve el resultado de la ejecución de la consulta.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Shared\Application\Contracts\Bus
 * @since 1.0.0
 * @version 1.0.0
 */
interface QueryBus
{
    /**
     * Ejecuta un query y devuelve su resultado.
     *
     * @param QueryContract $query El query a ejecutar (debe ser una clase que represente una intención).
     * @return mixed El resultado del query.
     */
    public function ask(QueryContract $query): mixed;
}