<?php

namespace App\Domains\Cuenta\Services;

// ACTIONS
use App\Domains\Propietario\Actions\GetPropietarioAction;
use App\Domains\TipoCuenta\Actions\GetTipoCuentaAction;
use App\Domains\Cuenta\Actions\StoreCuentaAction;
use App\Domains\Cuenta\DTOs\CuentaFormOptionsDTO;
use App\Domains\Cuenta\Actions\GetCuentaAction;
use App\Domains\Cuenta\Actions\UpdateCuentaAction;
use App\Domains\Cuenta\Actions\DestroyCuentaAction;
// DTOs
use App\Domains\Cuenta\DTOs\StoreCuentaDTO;
use App\Domains\Cuenta\DTOs\UpdateCuentaDTO;

// MODELS
use App\Models\Cuenta\Cuenta;

// CLASES DE LARAVEL PARA TIPAR
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Database\Eloquent\Builder;
use App\Domains\Cuenta\Resources\CuentaResource;

class CuentaService{
    public function __construct(
        private GetPropietarioAction $getPropietarioAction,
        private GetTipoCuentaAction $getTipoCuentaAction,
        private StoreCuentaAction $storeCuentaAction,
        private UpdateCuentaAction $updateCuentaAction,
        private GetCuentaAction $getCuentaAction,
        private DestroyCuentaAction $destroyCuentaAction
    )
    {
    }
    public function getOptions(): CuentaFormOptionsDTO{
        return new CuentaFormOptionsDTO(
            $this->getPropietarioAction->getAll(),
            $this->getTipoCuentaAction->getAll()
        );
    }

    public function store(array $data): Cuenta{
         $dto = StoreCuentaDTO::fromArray($data);
        return $this->storeCuentaAction->store($dto);
    }

    public function update(Cuenta $cuenta, array $data): bool{
        $dto = UpdateCuentaDTO::fromArray($data);
        if(!$this->canUpdateSaldoInicial($cuenta)){
            $dto->setExcept(['saldo_actual']);
        }
        return $this->updateCuentaAction->update($cuenta, $dto);
    }

    public function destroy(Cuenta $cuenta): bool{
        return $this->destroyCuentaAction->destroy($cuenta);
    }

    public function toggleActive(Cuenta $cuenta): bool{
        return $this->updateCuentaAction->toggleActive($cuenta);
    }

    public function getAllAvailableWhitDetails(): AnonymousResourceCollection{
        $cuentas = $this->getCuentaAction->getAllAvalaibleWithDetails();
        return CuentaResource::collection($cuentas);
    }
    public function getRecordsCount(): int{
        return $this->getCuentaAction->getRecordsCount();
    }

    public function canUpdateSaldoInicial(Cuenta $cuenta): bool{
        return !$cuenta->movimientos()->exists();
    }
}