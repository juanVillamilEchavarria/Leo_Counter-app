<?php

namespace App\Application\Propietario\Queries;
use App\Shared\Application\Contracts\Queries\QueryContract;
/**
 * Query que representa el caso de uso de obtener un propietario para mostrar con sus detalles.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Propietario\Queries
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class GetPropietarioForShowQuery implements QueryContract{
    public function __construct(
        public int $id
    )
    {
    }
}