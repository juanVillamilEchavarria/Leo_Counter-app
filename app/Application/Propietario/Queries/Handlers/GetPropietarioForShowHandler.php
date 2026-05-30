<?php
/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Propietario\Queries\Handlers;

use App\Application\Propietario\DTOs\PropietarioShowDTO;
use App\Application\Propietario\Contracts\Queries\Executors\PropietarioForShowQueryExecutorContract;
use App\Application\Propietario\Queries\GetPropietarioForShowQuery;
/**
 * Handler que se encarga de obtener un propietario con sus detalles completos.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Propietario\Queries\Handlers
 * @since 1.0.0
 * @version 1.0.0
 */

final readonly class GetPropietarioForShowHandler
{
    public function __construct(
        private PropietarioForShowQueryExecutorContract $executor
    ) {}

    public function __invoke(GetPropietarioForShowQuery $query): PropietarioShowDTO
    {
        return $this->executor->execute($query->id);
    }
}
