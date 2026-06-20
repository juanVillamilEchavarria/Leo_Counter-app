<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Http\Controllers\Api\Auditoria;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shared\TableQueryRequest;
use App\Shared\Application\Contracts\Bus\QueryBus;
use App\Application\Auditoria\Mappers\AuditoriaForTableMapper;
use App\Domains\Auditoria\Enums\AuditableTypes;
use App\Domains\Auditoria\Enums\AuditableActions;

/**
 * Controller API para auditorías.
 * Expone el endpoint de listado paginado server-side compatible con TanStack Table.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 */
final readonly class AuditoriaApiController extends Controller
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

        $data = $result->items->map(function($record){
            return [
                'id' => $record->id,
                'user' => $record->usuario?->name ?? null,
                'auditable_type' => $record->auditable_type instanceof AuditableTypes ? $record->auditable_type->value : $record->auditable_type,
                'auditable_id' => $record->auditable_id,
                'action' => $record->action instanceof AuditableActions ? $record->action->value : $record->action,
                'old_values' => $record->old_values,
                'new_values' => $record->new_values,
                'created_at' => $record->created_at ?? null,
            ];
        })->values()->toArray();

        return response()->json([
            'data' => $data,
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
