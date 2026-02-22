<?php

namespace App\Domains\Propietario\Services;

use App\Domains\Propietario\Repositories\Contracts\PropietarioReadRepositoryContract;
use App\Domains\Propietario\Repositories\Contracts\PropietarioWriteRepositoryContract;
use App\Domains\Propietario\DTOs\StoreAndUpdatePropietarioDTO;
use App\Domains\Propietario\Resources\PropietarioResource;
use App\Domains\Propietario\Exceptions\CannotDeletePropietarioException;
use App\Domains\Propietario\Resources\ShowPropietarioResource;
use App\Models\Propietario\Propietario;

class PropietarioService{
    public function __construct(
        private PropietarioReadRepositoryContract $propietarioReadRepository,
        private PropietarioWriteRepositoryContract $propietarioWriteRepository
    ){}

    public function store (array $data): Propietario{
        $dto = StoreAndUpdatePropietarioDTO::fromArray($data);
        return $this->propietarioWriteRepository->store($dto);

    }

    public function update(Propietario $propietario, array $data ): bool{
        $dto = StoreAndUpdatePropietarioDTO::fromArray($data);
        return $this->propietarioWriteRepository->update($propietario, $dto);
        
    }
    public function destroy(Propietario $propietario): bool{
        $cuentas = $propietario->cuentas;
        if(!empty($cuentas->toArray())){
            throw new CannotDeletePropietarioException ('No se puede eliminar el propietario, tiene cuentas asociadas');
        }
        return $this->propietarioWriteRepository->destroy($propietario);
    }

    public function getWithDetails(Propietario $propietario): ShowPropietarioResource{
        return ShowPropietarioResource::make($propietario->load('cuentas:id,nombre,propietario_id'));
    }
    public function getRecordsCount(): int{
        return $this->propietarioReadRepository->getRecordsCount();
    }
    public function getAll(){
        return PropietarioResource::collection($this->propietarioReadRepository->getAll());
    }
}