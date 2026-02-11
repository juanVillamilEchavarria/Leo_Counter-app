<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use App\Shared\Services\BalanceCheckerService;
use App\Http\Requests\Shared\SaldoValidateRequest;
use Illuminate\Support\Facades\Response;

class SaldoValidateController extends Controller
{
    public function __construct(
        private BalanceCheckerService $balanceCheckerService
    )
    {
    }
    public function __invoke(SaldoValidateRequest $request)
    {
        $validate = $request->validated();
        return Response::json([
            'allowed'=>(bool) $this->balanceCheckerService->canAfford($validate['cuenta_id'], $validate['monto'])
        ]);
    }
}
