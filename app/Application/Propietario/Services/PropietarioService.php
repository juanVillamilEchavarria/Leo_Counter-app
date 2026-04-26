<?php

namespace App\Application\Propietario\Services;

use App\Domains\Propietario\Contracts\Repositories\PropietarioReadRepositoryContract;
use App\Domains\Propietario\Contracts\Repositories\PropietarioRepositoryContract;
use App\Application\Propietario\DTOs\StoreAndUpdatePropietarioDTO;
use App\Http\Resources\Propietario\PropietarioResource;
use App\Domains\Propietario\Exceptions\CannotDeletePropietarioException;
use App\Http\Resources\Propietario\ShowPropietarioResource;
use App\Models\Propietario\Propietario;

class PropietarioService{
    public function __construct(
        private PropietarioReadRepositoryContract $propietarioReadRepository,
        private PropietarioRepositoryContract $propietarioRepository
    ){}

    public function store (array $data): Propietario{
        $dto = StoreAndUpdatePropietarioDTO::fromArray($data);
        return $this->propietarioRepository->store($dto);

    }

    public function update(Propietario $propietario, array $data ): bool{
        $dto = StoreAndUpdatePropietarioDTO::fromArray($data);
        return $this->propietarioRepository->update($propietario, $dto);
        
    }
    public function destroy(Propietario $propietario): bool{
        $cuentas = $propietario->cuentas;
        if(!empty($cuentas->toArray())){
            throw new CannotDeletePropietarioException ('No se puede eliminar el propietario, tiene cuentas asociadas');
        }
        return $this->propietarioRepository->destroy($propietario);
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