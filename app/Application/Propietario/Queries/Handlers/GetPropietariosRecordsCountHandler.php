<?php

namespace App\Application\Propietario\Queries\Handlers;

use App\Application\Propietario\Queries\GetPropietariosRecordsCountQuery;
use App\Application\Propietario\Contracts\Queries\Executors\GetPropietarioRecordsCountQueryExecutorContract;
/**
 * Handler que maneja la consulta para obtener el conteo de propietarios.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Propietario\Queries\Handlers
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class GetPropietariosRecordsCountHandler
{
    public function __construct(
        private GetPropietarioRecordsCountQueryExecutorContract $executor,
    ) {}

    public function __invoke(GetPropietariosRecordsCountQuery $query): int
    {
        return $this->executor->execute();
    }
}
