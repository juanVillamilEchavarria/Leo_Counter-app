<?php

namespace App\Http\Controllers\Api\Shared;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shared\SaldoValidateRequest;
use Illuminate\Support\Facades\Response;
use App\Shared\Application\Contracts\Bus\QueryBus;
use App\Application\Movimiento\Queries\CheckEnoughBalanceQuery;

class SaldoValidateController extends Controller
{
    public function __construct(
        private QueryBus $queryBus,
    )
    {
    }
    public function __invoke(SaldoValidateRequest $request)
    {
        $validate = $request->validated();
        return Response::json([
            'allowed'=>(bool) $this->queryBus->ask(new CheckEnoughBalanceQuery(cuenta_id: $validate['cuenta_id'], monto: $validate['monto'])),
        ]);
    }
}
