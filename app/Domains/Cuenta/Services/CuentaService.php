<?php

namespace App\Domains\Cuenta\Services;

// ACTIONS
use App\Domains\Propietario\Repositories\Contracts\PropietarioReadRepositoryContract;
use App\Domains\Cuenta\Repositories\Contracts\CuentaWriteRepositoryContract;
use App\Domains\TipoCuenta\Actions\GetTipoCuentaAction;
use App\Domains\Cuenta\Actions\StoreCuentaAction;
use App\Domains\Cuenta\DTOs\CuentaFormOptionsDTO;
use App\Domains\Cuenta\Actions\UpdateCuentaAction;
use App\Domains\Cuenta\Actions\DestroyCuentaAction;
use App\Domains\Cuenta\Repositories\Contracts\CuentaReadRepositoryContract;
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
        private PropietarioReadRepositoryContract $propietarioReadRepository,
        private CuentaWriteRepositoryContract $repository,
        private GetTipoCuentaAction $getTipoCuentaAction,
        private StoreCuentaAction $storeCuentaAction,
        private UpdateCuentaAction $updateCuentaAction,
        private CuentaReadRepositoryContract $cuentaReadRepository,
        private DestroyCuentaAction $destroyCuentaAction
    )
    {
    }
    public function getOptions(): CuentaFormOptionsDTO{
        return new CuentaFormOptionsDTO(
            $this->propietarioReadRepository->getAll(),
            $this->getTipoCuentaAction->getAll()
        );
    }

    public function store(array $data): Cuenta{
         $dto = StoreCuentaDTO::fromArray($data);
        return $this->repository->store($dto);
    }

    public function update(Cuenta $cuenta, array $data): bool{
        $dto = UpdateCuentaDTO::fromArray($data);
        if(!$this->canUpdateSaldoInicial($cuenta)){
            $dto->setExcept(['saldo_actual']);
        }
        return $this->repository->update($cuenta, $dto);
    }

    public function destroy(Cuenta $cuenta): bool{
        return $this->repository->destroy($cuenta);
    }

    public function toggleActive(Cuenta $cuenta): bool{
        return $this->repository->toggleActive($cuenta);
    }

    public function getAllAvailableWhitDetails(): AnonymousResourceCollection{
        $cuentas = $this->cuentaReadRepository->getAllWithDetails();
        return CuentaResource::collection($cuentas);
    }
    public function getRecordsCount(): int{
        return $this->cuentaReadRepository->getRecordsCount();
    }

    public function canUpdateSaldoInicial(Cuenta $cuenta): bool{
        return !$cuenta->movimientos()->exists();
    }
}