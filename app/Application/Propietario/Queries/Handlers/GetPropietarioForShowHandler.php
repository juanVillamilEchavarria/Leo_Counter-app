<?php
namespace App\Application\Propietario\Queries\Handlers;

use App\Application\Propietario\DTOs\PropietarioShowDTO;
use App\Application\Propietario\Contracts\Queries\Executors\PropietarioShowQueryExecutorContract;
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
        private PropietarioShowQueryExecutorContract $executor
    ) {}

    public function __invoke(GetPropietarioForShowQuery $query): PropietarioShowDTO
    {
        return $this->executor->execute($query->id);
    }
}
