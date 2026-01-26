<?php

namespace App\Domains\Presupuesto\Services;

use App\Domains\Presupuesto\Actions\StorePresupuestoMesActualAction;
use App\Domains\Categoria\Actions\GetCategoriaAction;
use App\Domains\Presupuesto\DTOs\PresupuestoMesActualFormOptionsDTO;
use App\Domains\Presupuesto\DTOs\StorePresupuestoDTO;
use App\Models\Presupuesto\Presupuesto;

class PresupuestoService{
    public function __construct(
        private StorePresupuestoMesActualAction $storePresupuestoMesActualAction,
        private GetCategoriaAction $getCategoriaAction
    )
    {
    }

    public function store(array $data): Presupuesto{
        $dto= StorePresupuestoDTO::fromArray($data);
        return $this->storePresupuestoMesActualAction->store($dto);
    }
    public function getOptions(){
        return new PresupuestoMesActualFormOptionsDTO(
            $this->getCategoriaAction->getAllByType(2)
        );
    }
}