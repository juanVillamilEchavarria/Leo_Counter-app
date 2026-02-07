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
use App\Shared\Enums\ComparativeOperators;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Domains\Presupuesto\Resources\PresupuestoResource;
use App\Domains\Presupuesto\Resources\PresupuestoMesActualResource;
// EXCEPTIONS
use App\Domains\Presupuesto\Exceptions\CannotStorePresupuestoException;
use App\Domains\Presupuesto\Exceptions\CannotUpdatePresupuestoException;

use Illuminate\Support\Carbon;
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
    private function storeValidate(StorePresupuestoMesActualDTO $dto): void{
        if( $this->getPresupuestoAction->getEqualPresupuesto($dto->categoria_id, $dto->periodo)->exists()){
            throw new CannotStorePresupuestoException(message: 'Ya existe un presupuesto para la fecha seleccionada');
        }
    }
    private function updateValidate(UpdatePresupuestoMesActualDTO $dto, Presupuesto $presupuesto): void{
        if( $this->getPresupuestoAction->getEqualPresupuesto($dto->categoria_id, $dto->periodo)
             ->where('id', '!=', $presupuesto->id)
            ->exists()
        ){
            throw new CannotUpdatePresupuestoException(message: 'Ya existe un presupuesto para la fecha seleccionada');
        }
    }
    private function canDuplicate(Presupuesto $presupuesto): bool{
    $nextMonth = $presupuesto->periodo->copy()->firstOfMonth()->addMonth();
    return !$this->getPresupuestoAction->getEqualPresupuesto($presupuesto->categoria_id, $nextMonth)->exists();
    }
    
    public function store(array $data): Presupuesto
    {
        $dto = StorePresupuestoMesActualDTO::fromArray($data);
        $this->storeValidate($dto);
        return $this->storePresupuestoMesActualAction->store($dto);
    }

    public function update(Presupuesto $presupuesto, array $data): bool
    {
        $dto = UpdatePresupuestoMesActualDTO::fromArray($data);
        $this->updateValidate($dto, $presupuesto);
        return $this->updatePresupuestoAction->update($presupuesto, $dto);
    }

    public function destroy(Presupuesto $presupuesto): bool
    {
        return $this->destroyPresupuestoAction->destroy($presupuesto);
    }

 

    public function duplicate(Presupuesto $presupuesto){
        if(!$this->canDuplicate($presupuesto)){
            throw new CannotStorePresupuestoException(message: 'Ya existe un presupuesto duplicado para este');
        }
        $dto = StorePresupuestoMesActualDTO::fromObject($presupuesto); 
        $dto->periodo = $presupuesto->periodo->copy()->firstOfMonth()->addMonth();
        $this->storeValidate($dto);
        return $this->storePresupuestoMesActualAction->store($dto);
    }


    public function getOptions()
    {
        return new PresupuestoFormOptionsDTO(
            $this->getCategoriaAction->getAllByType(2)
        );
    }

    public function getRecordsCount(PresupuestoVariants $type): int
    {
        return $type === PresupuestoVariants::MES_ACTUAL 
        ? $this->getPresupuestoAction->getMesActualRecordsCount()
        : $this->getPresupuestoAction->getHistoricRecordsCount();
    }


    public function getAllWithDetails(PresupuestoVariants $type): AnonymousResourceCollection
    {
        if($type === PresupuestoVariants::MES_ACTUAL) { // si es para la tabla de presupuestos del mes actual
            $presupuestos = $this->getPresupuestoAction
            ->getAllWithDetailsUntilPeriodo(ComparativeOperators::EQUALS, Carbon::now()->firstOfMonth())
            ->map(function ($presupuesto) { // se mapea cada presupuesto, y se le añade el campo al resource de isDuplicate para saber si ya tiene alguno duplicado
                $presupuesto->isDuplicate = $this->canDuplicate($presupuesto);
                return $presupuesto;
            });
            return PresupuestoMesActualResource::collection($presupuestos);
        }
        $presupuestos = $this->getPresupuestoAction->getAllWithDetailsUntilPeriodo(ComparativeOperators::LESS_THAN_OR_EQUAL, Carbon::now()->firstOfMonth());
        return PresupuestoResource::collection($presupuestos);
    }

}