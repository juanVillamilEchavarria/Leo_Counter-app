<?php

namespace App\Domains\Presupuesto\Services;

use App\Domains\Presupuesto\Actions\StorePresupuestoAction;
use App\Domains\Presupuesto\Actions\GetPresupuestoAction;
use App\Domains\Presupuesto\Actions\UpdatePresupuestoAction;
use App\Domains\Presupuesto\Actions\DestroyPresupuestoAction;
use App\Domains\Categoria\Actions\GetCategoriaAction;
use App\Domains\TipoPresupuesto\Actions\GetTipoPresupuestoAction;
use App\Domains\Presupuesto\DTOs\PresupuestoFormOptionsDTO;
use App\Domains\Presupuesto\DTOs\StorePresupuestoMesActualDTO;
use App\Domains\Presupuesto\DTOs\UpdatePresupuestoMesActualDTO;
use App\Domains\Presupuesto\DTOs\StorePresupuestoPorPeriodoDTO;
use App\Domains\Presupuesto\DTOs\UpdatePresupuestoPorPeriodoDTO;
use App\Models\Presupuesto\Presupuesto;
// ENUMS
use App\Domains\Presupuesto\Enums\DTOEnum;
use App\Domains\Presupuesto\Enums\PresupuestoVariants;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Domains\Presupuesto\Resources\PresupuestoResource;

class PresupuestoService
{
    public function __construct(
        private StorePresupuestoAction $storePresupuestoMesActualAction,
        private GetPresupuestoAction $getPresupuestoAction,
        private UpdatePresupuestoAction $updatePresupuestoAction,
        private DestroyPresupuestoAction $destroyPresupuestoAction,
        private GetCategoriaAction $getCategoriaAction,
        private GetTipoPresupuestoAction $getTipoPresupuestoAction
    ) {
    }
    private function resolveDTO(array $data, DTOEnum $context): object
{
    // Si vienen fechas, es un presupuesto por periodo
    if (!empty($data['fecha_inicio']) && !empty($data['fecha_final'])) {
        return $context === DTOEnum::STORE 
            ? StorePresupuestoPorPeriodoDTO::fromArray($data)
            : UpdatePresupuestoPorPeriodoDTO::fromArray($data);
    }

    // Si no, es presupuesto del mes actual
    return $context === DTOEnum::STORE
        ? StorePresupuestoMesActualDTO::fromArray($data)
        : UpdatePresupuestoMesActualDTO::fromArray($data);
}

    public function store(array $data): Presupuesto
    {

        $dto = $this->resolveDTO($data, DTOEnum::STORE);
        return $this->storePresupuestoMesActualAction->store($dto);
    }

    public function update(Presupuesto $presupuesto, array $data): bool
    {
        $dto = $this->resolveDTO($data, DTOEnum::UPDATE);
        return $this->updatePresupuestoAction->update($presupuesto, $dto);
    }

    public function destroy(Presupuesto $presupuesto): bool
    {
        return $this->destroyPresupuestoAction->destroy($presupuesto);
    }

    public function getOptions()
    {
        return new PresupuestoFormOptionsDTO(
            $this->getCategoriaAction->getAllByType(2),
            $this->getTipoPresupuestoAction->getAll()
        );
    }

    public function getRecordsCount(PresupuestoVariants $type): int
    {
        if($type === PresupuestoVariants::MES_ACTUAL) return $this->getPresupuestoAction->getRecordsCountMesActual();
        if($type === PresupuestoVariants::POR_PERIODO) return $this->getPresupuestoAction->getRecordsCountPorPeriodo();
        return $this->getPresupuestoAction->getRecordsCount();
    }


    public function getAllWithDetails(PresupuestoVariants $type): AnonymousResourceCollection
    {
        if($type === PresupuestoVariants::MES_ACTUAL) {
            $presupuestos = $this->getPresupuestoAction->getActualMesWithDetails();
            return PresupuestoResource::collection($presupuestos);
        }
        if($type === PresupuestoVariants::POR_PERIODO) {
            $presupuestos = $this->getPresupuestoAction->getPorPeriodoWithDetails();
            return PresupuestoResource::collection($presupuestos);
        }
        $presupuestos = $this->getPresupuestoAction->getAllWithDetails();
        return PresupuestoResource::collection($presupuestos);
    }

}