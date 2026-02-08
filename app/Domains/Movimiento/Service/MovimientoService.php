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
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;

use Illuminate\Support\Facades\DB;

class MovimientoService{
    public function __construct(
        private GetMovimientoAction $getMovimientoAction,
        private StoreMovimientoAction $storeMovimientoAction,
        private UpdateCuentaAction $updateCuentaAction,
        private GetCuentaAction $getCuentaAction,
        private BalanceCheckerService $balanceCheckerService,
        private ArchivoMovimientoService $archivoMovimientoService
    )
    {
    }
    private function executeMovimientoTransaction(StoreMovimientoDTO $dto, Cuenta $cuenta): Movimiento{
        return DB::transaction(function() use ($dto, $cuenta){
            $updateSaldoDTO = $this->resolveUpdateSaldoDTO($dto, $cuenta);
            $this->updateCuentaAction->update($cuenta, $updateSaldoDTO);
            $movimiento = $this->storeMovimientoAction->store($dto);
            if(!empty($dto->comprobantes)){
                $dtoArchivo = ThrowArchivoMovimientoDTO::fromMovimientoAndDTO($dto, $movimiento);
                    $this->archivoMovimientoService->store($dtoArchivo);
                }
                return $movimiento;
        });
    }
    private function resolveUpdateSaldoDTO(StoreMovimientoDTO $dto, Cuenta $cuenta) : UpdateSaldoDTO{
        return $dto->tipo_movimiento_id === TipoMovimientoEnum::INGRESO->value ?
         (new UpdateSaldoDTO($cuenta->saldo_actual))->inflow($dto->monto)
        :(new UpdateSaldoDTO($cuenta->saldo_actual))->outflow($dto->monto);
    }
    private function resolveCuenta(StoreMovimientoDTO $dto) : Cuenta{
        if($dto->tipo_movimiento_id === TipoMovimientoEnum::INGRESO->value ){
            return $this->getCuentaAction->where('id', $dto->cuenta_id)->firstOrFail();
        }
         try {
             return $this->balanceCheckerService->getCuentaIfCanAfford($dto->cuenta_id, $dto->monto);
            } catch (InsufficientBalanceException $e) {
                throw new CannotStoreMovimientoException(message: 'No se pudo almacenar el movimiento: '. $e->getMessage());
            }
        
    }
    public function store(StoreMovimientoDTO | array $data): Movimiento{
        if(is_array($data)) $data = StoreMovimientoDTO::fromArray($data);
        $cuenta = $this->resolveCuenta($data);
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