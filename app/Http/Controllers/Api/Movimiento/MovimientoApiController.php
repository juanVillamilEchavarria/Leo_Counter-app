<?php

namespace App\Http\Controllers\Api\Movimiento;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shared\TableQueryRequest;
use App\Application\Movimiento\Services\MovimientoService;
use App\Domains\Movimiento\Enums\MovimientoVariants;

class MovimientoApiController extends Controller
{
    public function __construct(
        private MovimientoService $movimientoService
    )
    {
    }

    public function totalPaginated(TableQueryRequest $request){
        
        return response()->json([
            'data'=>$this->movimientoService->getAllPaginated(MovimientoVariants::TOTAL, $request->validated()),
            'meta'=> $this->movimientoService->getPaginatorMetaData()
        ]);
    }
}
