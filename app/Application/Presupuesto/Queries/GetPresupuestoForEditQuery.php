<?php

namespace App\Application\Presupuesto\Queries;

use App\Shared\Application\Contracts\Queries\QueryContract;

/**
 * Query que representa la intencion de obtener un presupuesto para su edicion.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class GetPresupuestoForEditQuery implements QueryContract
{
    public function __construct(
        public string $id
    ){}
}