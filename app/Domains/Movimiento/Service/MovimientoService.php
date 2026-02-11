<?php

namespace App\Domains\Movimiento\Service;


// Actions
use App\Domains\Cuenta\Actions\GetCuentaAction;
use App\Domains\Movimiento\Actions\GetMovimientoAction;
use App\Domains\Movimiento\Actions\StoreMovimientoAction;
use App\Domains\Movimiento\Actions\UpdateMovimientoAction;
use App\Domains\Cuenta\Actions\UpdateCuentaAction;
// Services 
use App\Shared\Services\BalanceCheckerService;
use App\Domains\ArchivoMovimiento\Services\ArchivoMovimientoService;
use App\Domains\MovimientoFijo\Services\MovimientoFijoService;
// DTOs y Resources
use App\Domains\Movimiento\DTOs\StoreMovimientoDTO;
use App\Domains\Movimiento\DTOs\UpdateMovimientoDTO;
use App\Domains\Cuenta\DTOs\UpdateSaldoDTO;
use App\Domains\Movimiento\Resources\MovimientoResource;
use App\Domains\Movimiento\Resources\ShowMovimientoResource;
use App\Domains\Movimiento\Resources\EditMovimientoResource;
use App\Domains\ArchivoMovimiento\DTOs\ThrowArchivoMovimientoDTO;
use App\Shared\DTOs\WhereFilterQueryDTO;
// Models
use App\Models\Movimiento\Movimiento;
// Exceptions
use App\Domains\Movimiento\Exceptions\CannotStoreMovimientoException;
use App\Models\Cuenta\Cuenta;
use App\Shared\Exceptions\InsufficientBalanceException;
// Enums y types
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Domains\Movimiento\Enums\MovimientoVariants;
use App\Domains\Movimiento\Enums\ResourceEnum;
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;
use App\Domains\Movimiento\Enums\MoneyFlowEnum;
use App\Shared\Enums\ComparativeOperators;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MovimientoService{
    public function __construct(
        private GetMovimientoAction $getMovimientoAction,
        private StoreMovimientoAction $storeMovimientoAction,
        private UpdateMovimientoAction $updateMovimientoAction,
        private UpdateCuentaAction $updateCuentaAction,
        private GetCuentaAction $getCuentaAction,
        private BalanceCheckerService $balanceCheckerService,
        private ArchivoMovimientoService $archivoMovimientoService,
        private MovimientoFijoService $movimientoFijoService
    )
    {
    }
    // METODOS PRIVADOS PARA LA LOGICA PROPIA DEL SERVICE
    private function executeMovimientoTransaction(StoreMovimientoDTO | UpdateMovimientoDTO $dto, Cuenta $cuenta, Movimiento $movimiento): Movimiento{
        return DB::transaction(function() use ($dto, $cuenta, $movimiento){
            $updateSaldoDTO = $this->resolveUpdateSaldoDTO($dto, $cuenta, $movimiento);
            if(!empty($dto->comprobantes_delete_ids)) $this->syncComprobantes($dto, $movimiento);
            $this->updateCuentaAction->update($cuenta, $updateSaldoDTO); // si todo sale bien se actualiza el saldo
            if(!empty($dto->comprobantes)){ // si hay comprobantes, se almacenan
                $dtoArchivo = ThrowArchivoMovimientoDTO::fromMovimientoAndDTO($dto, $movimiento);
                    $this->archivoMovimientoService->store($dtoArchivo);
                } 
                return $movimiento; // se retorna el movimiento
        });
    }

    private function resolveUpdateSaldoDTO(StoreMovimientoDTO | UpdateMovimientoDTO $dto, Cuenta $cuenta, Movimiento $movimiento): UpdateSaldoDTO{
        return  $dto instanceof UpdateMovimientoDTO ?  
            $this->resolveUpdateSaldoTransaction($dto, $movimiento, new UpdateSaldoDTO($cuenta->saldo_actual), $cuenta)
            : $this->resolveUpdateSaldo($dto, $cuenta);
    }

    private function resolveUpdateSaldoTransaction(StoreMovimientoDTO | UpdateMovimientoDTO $dto, Movimiento $movimiento, UpdateSaldoDTO $updateSaldoDTO, Cuenta $cuenta): UpdateSaldoDTO{
            $updateSaldoDTO = new UpdateSaldoDTO($cuenta->saldo_actual);
            $this->applyMoneyFlow($movimiento->tipo_movimiento_id, $movimiento->monto, $updateSaldoDTO, MoneyFlowEnum::REVERT);
            $this->applyMoneyFlow($dto->tipo_movimiento_id, $dto->monto, $updateSaldoDTO);
            return $updateSaldoDTO;
    }

    private function syncComprobantes (UpdateMovimientoDTO $dto, Movimiento $movimiento){
       $movimiento->archivoMovimientos()->whereIn('id', $dto->comprobantes_delete_ids)->delete();
       
    }

    private function applyMoneyFlow(int $tipo_movimiento_id, float $monto, UpdateSaldoDTO $updateSaldoDTO, MoneyFlowEnum $moneyFlow = MoneyFlowEnum::APPLY): UpdateSaldoDTO{
        if($moneyFlow === MoneyFlowEnum::APPLY){
            return $tipo_movimiento_id === TipoMovimientoEnum::INGRESO->value ?
            $updateSaldoDTO->inflow($monto)
            :$updateSaldoDTO->outflow($monto);
        }
        return $tipo_movimiento_id === TipoMovimientoEnum::INGRESO->value ?
            $updateSaldoDTO->outflow($monto)
            :$updateSaldoDTO->inflow($monto);
    }

    private function resolveUpdateSaldo (StoreMovimientoDTO | UpdateMovimientoDTO $dto,Cuenta $cuenta){
        $updateSaldoDTO = new UpdateSaldoDTO($cuenta->saldo_actual);
        return $this->applyMoneyFlow($dto->tipo_movimiento_id, $dto->monto, $updateSaldoDTO);
    }
    private function resolveCuenta(StoreMovimientoDTO | UpdateMovimientoDTO $dto) : Cuenta{
        if($dto->tipo_movimiento_id === TipoMovimientoEnum::INGRESO->value ){
            return $this->getCuentaAction->where('id', $dto->cuenta_id)->firstOrFail();
        }
         try {
             return $this->balanceCheckerService->getCuentaIfCanAfford($dto->cuenta_id, $dto->monto);
            } catch (InsufficientBalanceException $e) {
                throw new CannotStoreMovimientoException(message: 'No se pudo almacenar el movimiento: '. $e->getMessage());
            }
        
    }
    // METODOS PUBLICOS
    public function store(StoreMovimientoDTO | array $data): Movimiento{
        if(is_array($data)) $data = StoreMovimientoDTO::fromArray($data);
        $cuenta = $this->resolveCuenta($data);
        $movimiento = $this->storeMovimientoAction->store($data);
        return $this->executeMovimientoTransaction($data, $cuenta, $movimiento);
    }
    public function update(Movimiento $movimiento, array $data){
        $dto = UpdateMovimientoDTO::fromArray($data);
        $cuenta = $this->resolveCuenta($dto);
        $this->updateMovimientoAction->update($movimiento, $dto);
        return $this->executeMovimientoTransaction($dto, $cuenta, $movimiento);
        
    }


    public function getOptions(){
      return $this->movimientoFijoService->getOptions();
    }

    public function getWithDetails(Movimiento $movimiento, ResourceEnum $resource = ResourceEnum::SHOW) : ShowMovimientoResource | EditMovimientoResource{
        return $resource === ResourceEnum::SHOW ?
        ShowMovimientoResource::make($this->getMovimientoAction->getWithDetails($movimiento)):
        EditMovimientoResource::make($movimiento->load('archivoMovimientos'));
        ;
    }

    public function getAll(MovimientoVariants $variant = MovimientoVariants::TOTAL) : AnonymousResourceCollection{
        if($variant === MovimientoVariants::ESPONTANEO){
            $wheres = [
                new WhereFilterQueryDTO(
                    'fecha',
                    ComparativeOperators::EQUALS,
                    Carbon::now()->format('Y-m-d')
                ),
                new WhereFilterQueryDTO(
                    'movimiento_pendiente_id',
                    ComparativeOperators::EQUALS,
                    null
                )
            ];
            return MovimientoResource::collection($this->getMovimientoAction->getAllWithDetailsWhere($wheres));
        }
         return MovimientoResource::collection($this->getMovimientoAction->getAllWithDetails());
    }
    public function getRecordsCount(MovimientoVariants $variant = MovimientoVariants::TOTAL): int{
            return $variant === MovimientoVariants::ESPONTANEO ? $this->getMovimientoAction->getEspontaneoRecordsCount() :
            $this->getMovimientoAction->getRecordsCount();
    }
}