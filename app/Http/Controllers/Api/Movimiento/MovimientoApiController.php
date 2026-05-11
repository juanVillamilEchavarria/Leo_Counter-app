<?php

namespace App\Http\Controllers\Api\Movimiento;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shared\TableQueryRequest;
use App\Shared\Application\Contracts\Bus\QueryBus;
use App\Application\Movimiento\Mappers\MovimientoForTableMapper;
use App\Http\Resources\Movimiento\MovimientoResource;

class MovimientoApiController extends Controller
{
    public function __construct(
        private QueryBus $queryBus
    )
    {
    }

    public function totalPaginated(TableQueryRequest $request){
        $mapper = new MovimientoForTableMapper();
        $query = $mapper->map((object) $request->validated());
        $result = $this->queryBus->ask($query);

        return response()->json([
            'data' => MovimientoResource::collection($result->items),
            'meta' => [
                'currentPage' => $result->currentPage,
                'perPage' => $result->perPage,
                'lastPage' => $result->lastPage,
                'total' => $result->total,
                'from' => ($result->currentPage - 1) * $result->perPage + 1,
                'to' => min($result->total, $result->currentPage * $result->perPage),
            ]
        ]);
    }
}
