<?php

namespace App\Http\Controllers\Api\Presupuesto;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shared\TableQueryRequest;
use App\Application\Presupuesto\Services\PresupuestoService;
use App\Domains\Presupuesto\Enums\PresupuestoVariants;

class PresupuestoHistoricoApiController extends Controller
{
    public function __construct(
        private PresupuestoService $presupuestoService
    )
    {
    }

    public function historicosPaginated(TableQueryRequest $request)
    {
        return response()->json([
            'data' => $this->presupuestoService->getAllPaginated(PresupuestoVariants::HISTORICO, $request->validated()),
            'meta' => $this->presupuestoService->getPaginatorMetaData()
        ]);
    }
}
