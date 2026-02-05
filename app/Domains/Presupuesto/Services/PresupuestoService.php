<?php

namespace App\Domains\Presupuesto\Services;

use App\Domains\Presupuesto\Actions\StorePresupuestoAction;
use App\Domains\Presupuesto\Actions\GetPresupuestoAction;
use App\Domains\Presupuesto\Actions\UpdatePresupuestoAction;
use App\Domains\Presupuesto\Actions\DestroyPresupuestoAction;
use App\Domains\Categoria\Actions\GetCategoriaAction;
use App\Domains\Presupuesto\DTOs\PresupuestoFormOptionsDTO;
use App\Domains\Presupuesto\DTOs\StorePresupuestoMesActualDTO;
use App\Domains\Presupuesto\DTOs\UpdatePresupuestoMesActualDTO;
use App\Models\Presupuesto\Presupuesto;
// ENUMS
use App\Domains\Presupuesto\Enums\DTOEnum;
use App\Domains\Presupuesto\Enums\PresupuestoVariants;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Domains\Presupuesto\Resources\PresupuestoResource;
use App\Domains\Presupuesto\Resources\PresupuestoMesActualResource;
// EXCEPTIONS
use App\Domains\Presupuesto\Exceptions\CannotStorePresupuestoException;
class PresupuestoService
{
    public function __construct(
        private StorePresupuestoAction $storePresupuestoMesActualAction,
        private GetPresupuestoAction $getPresupuestoAction,
        private UpdatePresupuestoAction $updatePresupuestoAction,
        private DestroyPresupuestoAction $destroyPresupuestoAction,
        private GetCategoriaAction $getCategoriaAction
    ) {
    }
    private function resolveDTO(array $data, DTOEnum $context): object
    {
        return $context === DTOEnum::STORE
            ? StorePresupuestoMesActualDTO::fromArray($data)
            : UpdatePresupuestoMesActualDTO::fromArray($data);
    }
    
    public function store(array $data): Presupuesto
    {
        $dto = $this->resolveDTO($data, DTOEnum::STORE);
        if( $this->getPresupuestoAction->getEqualPresupuesto($dto->categoria_id, $dto->periodo)->exists()){
            throw new CannotStorePresupuestoException(message: 'Ya existe un presupuesto para la fecha seleccionada');

        }
        return $this->storePresupuestoMesActualAction->store($dto);
    }

    public function update(Presupuesto $presupuesto, array $data): bool
    {
        $dto = $this->resolveDTO($data, DTOEnum::UPDATE);
        if( $this->getPresupuestoAction->getEqualPresupuesto($dto->categoria_id, $dto->periodo)
             ->where('id', '!=', $presupuesto->id)
            ->exists()
        ){
            throw new CannotStorePresupuestoException(message: 'Ya existe un presupuesto para la fecha seleccionada');
        }
        return $this->updatePresupuestoAction->update($presupuesto, $dto);
    }

    public function destroy(Presupuesto $presupuesto): bool
    {
        return $this->destroyPresupuestoAction->destroy($presupuesto);
    }

    public function canDuplicate(Presupuesto $presupuesto): bool{
        $nextMonth = $presupuesto->periodo->copy()->firstOfMonth()->addMonth();
        return !$this->getPresupuestoAction->getEqualPresupuesto($presupuesto->categoria_id, $nextMonth)->exists();
    }


    public function getOptions()
    {
        return new PresupuestoFormOptionsDTO(
            $this->getCategoriaAction->getAllByType(2)
        );
    }

    public function getRecordsCount(PresupuestoVariants $type): int
    {
        if($type === PresupuestoVariants::MES_ACTUAL) return $this->getPresupuestoAction->getRecordsCountMesActual();
        return $this->getPresupuestoAction->getRecordsCount();
    }


    public function getAllWithDetails(PresupuestoVariants $type): AnonymousResourceCollection
    {
        if($type === PresupuestoVariants::MES_ACTUAL) {
            $presupuestos = $this->getPresupuestoAction
            ->getActualMesWithDetails()
            ->map(function ($presupuesto) {
                $presupuesto->isDuplicate = $this->canDuplicate($presupuesto);
                return $presupuesto;
            });
            return PresupuestoMesActualResource::collection($presupuestos);
        }
        $presupuestos = $this->getPresupuestoAction->getAllWithDetails();
        return PresupuestoResource::collection($presupuestos);
    }

}