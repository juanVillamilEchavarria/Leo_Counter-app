<?php

namespace App\Domains\Movimiento\Service\Domain;

use App\Domains\Movimiento\Service\Domain\MovimientoAttachmentService;
use App\Domains\Movimiento\Actions\StoreMovimientoAction;
use App\Domains\Movimiento\Actions\UpdateMovimientoAction;
use App\Domains\Movimiento\Actions\DestroyMovimientoAction;
use App\Domains\Cuenta\Actions\UpdateCuentaAction;
use App\Domains\Cuenta\Actions\GetCuentaAction;
use App\Domains\Movimiento\DTOs\StoreMovimientoDTO;
use App\Domains\Movimiento\DTOs\UpdateMovimientoDTO;
use App\Domains\Movimiento\DTOs\DestroyMovimientoDTO;
use App\Domains\Cuenta\DTOs\UpdateSaldoDTO;
use App\Models\Cuenta\Cuenta;
use App\Models\Movimiento\Movimiento;
use App\Domains\Movimiento\Enums\MoneyFlowEnum;
use Illuminate\Support\Facades\DB;

class MovimientoFinancialService {
    public function __construct(
        private GetCuentaAction $getCuentaAction,
        private UpdateCuentaAction $updateCuentaAction,
        private StoreMovimientoAction $storeMovimientoAction,
        private UpdateMovimientoAction $updateMovimientoAction,
        private DestroyMovimientoAction $destroyMovimientoAction,
        private MovimientoAttachmentService $movimientoAttachmentService
    )
    {
    }

    // METODO PUBLICO PARA EJECUTAR LA TRANSACCION FINANCIERA
     public function executeMovimientoTransaction(StoreMovimientoDTO | UpdateMovimientoDTO | DestroyMovimientoDTO $dto, Cuenta $cuenta, ?Movimiento $movimiento): Movimiento{
        return DB::transaction(function() use ($dto, $cuenta, $movimiento){
    
            if($dto instanceof StoreMovimientoDTO){
                $movimiento = $this->storeMovimientoAction->store($dto);
            }
            $updateSaldoDTO = $this->resolveUpdateSaldoDTO($dto, $cuenta, $movimiento);
            $this->executeAttachmentServiceFunction($dto, $movimiento);
            $dto instanceof UpdateMovimientoDTO && $this->updateMovimientoAction->update($movimiento, $dto);

            $this->updateCuentaAction->update($cuenta, $updateSaldoDTO); // si todo sale bien se actualiza el saldo
            $dto instanceof DestroyMovimientoDTO && $this->destroyMovimientoAction->destroy($movimiento);
                return $movimiento ; // se retorna el movimiento
        });
    }

    // METODOS PRIVADOS

    private function executeAttachmentServiceFunction(UpdateMovimientoDTO | StoreMovimientoDTO | DestroyMovimientoDTO $dto, Movimiento $movimiento): void{
            !$dto instanceof DestroyMovimientoDTO ? 
            $this->movimientoAttachmentService->sync($dto, $movimiento):
            $this->movimientoAttachmentService->deleteAllAttachments($movimiento);
    }
    // funcion que resuelve la actualizacion del saldo
        private function resolveUpdateSaldoDTO(StoreMovimientoDTO | UpdateMovimientoDTO | DestroyMovimientoDTO $dto, Cuenta $cuenta, Movimiento $movimiento): UpdateSaldoDTO | null{
            if($dto instanceof StoreMovimientoDTO) return $this->resolveUpdateSaldo($dto, $cuenta);
            if($dto instanceof UpdateMovimientoDTO) return $this->resolveUpdateSaldoTransaction($dto, $movimiento, new UpdateSaldoDTO($cuenta->saldo_actual), $cuenta);
            if($dto instanceof DestroyMovimientoDTO) return $this->resolveDestroyMovimientoTransaction($movimiento, $cuenta);
            return null;

        }


        // funcion que resuelve la actualizacion de saldo cuando es para actualizar el movimiento
        private function resolveUpdateSaldoTransaction(UpdateMovimientoDTO $dto, Movimiento $movimiento, UpdateSaldoDTO $updateSaldoDTO, Cuenta $cuenta): UpdateSaldoDTO{
            
            if($cuenta->id !== $movimiento->cuenta_id){ // si la cuenta cambio, se resta restaura el monto de la cuenta anterior
                    $oldCuenta= $this->getCuentaAction->where('id', $movimiento->cuenta_id)->firstOrFail();
                    $saldoDto = new UpdateSaldoDTO($oldCuenta->saldo_actual);
                    $saldoDto->moneyFlow($movimiento->tipo_movimiento_id, $movimiento->monto, MoneyFlowEnum::REVERT);
                    $this->updateCuentaAction->update($oldCuenta, $saldoDto);
             }else{ // sino, se revierte el movimiento para la cuenta
                 $updateSaldoDTO->moneyFlow($movimiento->tipo_movimiento_id, $movimiento->monto, MoneyFlowEnum::REVERT);
             } 
            // se aplica el movimiento
            $updateSaldoDTO->moneyFlow($dto->tipo_movimiento_id, $dto->monto, MoneyFlowEnum::APPLY);
            return $updateSaldoDTO;
    }

    private function resolveDestroyMovimientoTransaction(Movimiento $movimiento, Cuenta $cuenta): UpdateSaldoDTO{
        $updateSaldoDTO = new UpdateSaldoDTO($cuenta->saldo_actual);
        return $updateSaldoDTO->moneyFlow($movimiento->tipo_movimiento_id, $movimiento->monto, MoneyFlowEnum::REVERT);
    }

     // funcion que resuelve la actualizacion de saldo cuando es para crear el movimiento   
        private function resolveUpdateSaldo (StoreMovimientoDTO $dto,Cuenta $cuenta){
        $updateSaldoDTO = new UpdateSaldoDTO($cuenta->saldo_actual);
        return $updateSaldoDTO->moneyFlow($dto->tipo_movimiento_id, $dto->monto, MoneyFlowEnum::APPLY);
    }
}