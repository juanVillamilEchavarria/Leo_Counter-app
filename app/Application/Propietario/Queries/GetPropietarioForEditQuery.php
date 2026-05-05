<?php

namespace App\Application\Propietario\Queries;

use App\Shared\Application\Contracts\Queries\QueryContract;

/**
 * Query para obtener los datos de un propietario específico.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Propietario\Queries
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class GetPropietarioForEditQuery implements QueryContract
{
    public function __construct(
        public int $id,
    ) {}
}
