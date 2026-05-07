<?php

namespace App\Http\Controllers\Api\Presupuesto;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shared\TableQueryRequest;
use App\Application\Presupuesto\Queries\ListHistoricPresupuestosForTableQuery;
use App\Application\Presupuesto\Mappers\ListHistoricPresupuestosForTableMapper;
use App\Http\Resources\Presupuesto\PresupuestoForTableResource;
use App\Shared\Application\Contracts\Bus\QueryBus;

class PresupuestoHistoricoApiController extends Controller
{
    public function __construct(
        private QueryBus $queryBus,
        private ListHistoricPresupuestosForTableMapper $mapper
    )
    {
    }

    public function historicosPaginated(TableQueryRequest $request)
    {
        /**
         * @var ListHistoricPresupuestosForTableQuery
         */
        $query = $this->mapper->map($request);
        $paginated = $this->queryBus->ask($query);
        return PresupuestoForTableResource::make($paginated);
    }
}
