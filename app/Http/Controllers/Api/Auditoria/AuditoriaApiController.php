<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
namespace App\Http\Controllers\Api\Auditoria;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shared\TableQueryRequest;
use App\Shared\Application\Contracts\Bus\QueryBus;
use App\Application\Auditoria\Mappers\AuditoriaForTableMapper;
use App\Domains\Auditoria\Enums\AuditableTypes;
use App\Domains\Auditoria\Enums\AuditableActions;
use App\Http\Resources\Auditoria\AudotoriaResource;
use App\Http\Resources\Shared\PaginationMetaResource;

/**
 * Controller API para auditorías.
 * Expone el endpoint de listado paginado server-side compatible con TanStack Table.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 */
final  class AuditoriaApiController extends Controller
{
    public function __construct(
        private QueryBus $queryBus,
        private AuditoriaForTableMapper $mapper
    )
    {
    }

    public function index(TableQueryRequest $request){
        $query = $this->mapper->map($request);
        $result = $this->queryBus->ask($query);
        $data = AudotoriaResource::collection($result->items);
        

        return response()->json([
            'data' => $data,
            'meta' => PaginationMetaResource::make($result),
        ]);
    }
}
