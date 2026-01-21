<?php

namespace App\Domains\Propietario\Services;

use App\Domains\Propietario\Actions\GetPropietarioAction;
use App\Domains\Propietario\Actions\StorePropietarioAction;
use App\Domains\Propietario\Actions\UpdatePropietarioAction;
use App\Domains\Propietario\Actions\DestroyPropietarioAction;
use App\Domains\Propietario\DTOs\StoreAndUpdatePropietarioDTO;
use App\Models\Propietario\Propietario;

class PropietarioService{
    public function __construct(
        private GetPropietarioAction $getPropietarioAction,
        private StorePropietarioAction $storePropietarioAction,
        private UpdatePropietarioAction $updatePropietarioAction,
        private DestroyPropietarioAction $destroyPropietarioAction
    ){}

    public function store (array $data): Propietario{
        $dto = StoreAndUpdatePropietarioDTO::fromArray($data);
        return $this->storePropietarioAction->store($dto);

    }

    public function update(Propietario $propietario, array $data ): bool{
        $dto = StoreAndUpdatePropietarioDTO::fromArray($data);
        return $this->updatePropietarioAction->update($propietario, $dto);
        
    }
    public function destroy(Propietario $propietario): bool{
        return $this->destroyPropietarioAction->destroy($propietario);
    }
    public function getRecordsCount(): int{
        return $this->getPropietarioAction->getRecordsCount();
    }
    public function getAll(){
        return $this->getPropietarioAction->getAll();
    }
}