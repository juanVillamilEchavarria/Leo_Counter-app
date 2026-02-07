<?php

namespace App\Domains\Movimiento\Service;


// Actions
use App\Domains\Cuenta\Actions\GetCuentaAction;
use App\Domains\Movimiento\Actions\GetMovimientoAction;
use App\Domains\Movimiento\Actions\StoreMovimientoAction;
use App\Domains\Cuenta\Actions\UpdateCuentaAction;
// Services 
use App\Shared\Services\BalanceCheckerService;
use App\Domains\ArchivoMovimiento\Services\ArchivoMovimientoService;
// DTOs y Resources
use App\Domains\Movimiento\DTOs\StoreMovimientoDTO;
use App\Domains\Cuenta\DTOs\UpdateSaldoDTO;
use App\Domains\Movimiento\Resources\MovimientoResource;
use App\Domains\Movimiento\Resources\ShowMovimientoResource;
use App\Domains\ArchivoMovimiento\DTOs\ThrowArchivoMovimientoDTO;
// Models
use App\Models\Movimiento\Movimiento;
// Exceptions
use App\Domains\Movimiento\Exceptions\CannotStoreMovimientoException;
use App\Models\Cuenta\Cuenta;
use App\Shared\Exceptions\InsufficientBalanceException;
// Enums y types
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

use Illuminate\Support\Facades\DB;

class MovimientoService{
    public function __construct(
        private GetMovimientoAction $getMovimientoAction,
        private StoreMovimientoAction $storeMovimientoAction,
        private UpdateCuentaAction $updateCuentaAction,
        private BalanceCheckerService $balanceCheckerService,
        private ArchivoMovimientoService $archivoMovimientoService
    )
    {
    }
    private function executeMovimientoTransaction(StoreMovimientoDTO $dto, Cuenta $cuenta): Movimiento{
        return DB::transaction(function() use ($dto, $cuenta){
            $updateSaldoDTO = (new UpdateSaldoDTO($cuenta->saldo_actual))->outflow($dto->monto);
            $this->updateCuentaAction->update($cuenta, $updateSaldoDTO);
            $movimiento = $this->storeMovimientoAction->store($dto);
            if(!empty($dto->comprobantes)){
                $dtoArchivo = new ThrowArchivoMovimientoDTO(
                        comprobantes: $dto->comprobantes,
                        categoria: $movimiento->categoria->nombre,
                        tipo_movimiento: $movimiento->tipo_movimiento->tipo_movimiento,
                        movimiento_id: $movimiento->id);
                    $this->archivoMovimientoService->store($dtoArchivo);
                }
                return $movimiento;
        });
    }
    public function store(StoreMovimientoDTO | array $data): Movimiento{
        if(is_array($data)) $data = StoreMovimientoDTO::fromArray($data);
        try {
             $cuenta= $this->balanceCheckerService->getCuentaIfCanAfford($data->cuenta_id, $data->monto);
        } catch (InsufficientBalanceException $e) {
            throw new CannotStoreMovimientoException(message: 'No se pudo almacenar el movimiento: '. $e->getMessage());
        }
        return $this->executeMovimientoTransaction($data, $cuenta);
    }

    public function getWithDetails(Movimiento $movimiento) : ShowMovimientoResource{
        return ShowMovimientoResource::make($this->getMovimientoAction->getWithDetails($movimiento));
    }

    public function getAll() : AnonymousResourceCollection{
         return MovimientoResource::collection($this->getMovimientoAction->getAllWithDetails());
    }
    public function getRecordsCount(): int{
        return $this->getMovimientoAction->getRecordsCount();
    }
}