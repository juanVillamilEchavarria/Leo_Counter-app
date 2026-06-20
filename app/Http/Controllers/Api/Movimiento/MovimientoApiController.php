<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Http\Controllers\Api\Movimiento;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shared\TableQueryRequest;
use App\Shared\Application\Contracts\Bus\QueryBus;
use App\Application\Movimiento\Mappers\MovimientoForTableMapper;
use App\Http\Resources\Movimiento\MovimientoResource;
use App\Http\Resources\Shared\PaginationMetaResource;

class MovimientoApiController extends Controller
{
    public function __construct(
        private QueryBus $queryBus,
        private MovimientoForTableMapper $mapper
    )
    {
    }

    public function totalPaginated(TableQueryRequest $request){
        $query = $this->mapper->map($request);
        $result = $this->queryBus->ask($query);

        return response()->json([
            'data' => MovimientoResource::collection($result->items),
            'meta' => PaginationMetaResource::make($result),
        ]);
    }
}
