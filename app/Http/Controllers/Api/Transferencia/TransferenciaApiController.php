<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
namespace App\Http\Controllers\Api\Transferencia;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shared\TableQueryRequest;
use App\Shared\Application\Contracts\Bus\QueryBus;
use App\Application\Transferencia\Mappers\TransferenciaForTableMapper;
use App\Http\Resources\Transferencia\TransferenciaResource;

/**
 * Controlador API para Transferencias - listado server-side (tabla).
 */
class TransferenciaApiController extends Controller
{
    public function __construct(
        private QueryBus $queryBus,
        private TransferenciaForTableMapper $mapper
    )
    {
    }

    public function totalPaginated(TableQueryRequest $request){
        $query = $this->mapper->map($request);
        $result = $this->queryBus->ask($query);

        return response()->json([
            'data' => TransferenciaResource::collection($result->items),
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
