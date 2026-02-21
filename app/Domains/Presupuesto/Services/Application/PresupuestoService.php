<?php

namespace App\Domains\Presupuesto\Services\Application;

use App\Domains\Presupuesto\Services\Domain\PresupuestoQueryService;
use App\Domains\Presupuesto\Actions\StorePresupuestoAction;
use App\Domains\Presupuesto\Repositories\Contracts\PresupuestoReadRepositoryContract;
use App\Domains\Presupuesto\Actions\UpdatePresupuestoAction;
use App\Domains\Presupuesto\Actions\DestroyPresupuestoAction;
use App\Domains\Categoria\Repositories\Contracts\CategoriaReadRepositoryContract;
use App\Domains\Presupuesto\DTOs\PresupuestoFormOptionsDTO;
use App\Domains\Presupuesto\DTOs\StorePresupuestoMesActualDTO;
use App\Shared\DTOs\Querys\TableQueryDTO;
use App\Domains\Presupuesto\DTOs\UpdatePresupuestoMesActualDTO;
use App\Models\Presupuesto\Presupuesto;
// ENUMS
use App\Domains\Presupuesto\Enums\PresupuestoVariants;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
// EXCEPTIONS
use App\Domains\Presupuesto\Exceptions\CannotStorePresupuestoException;
use App\Domains\Presupuesto\Exceptions\CannotUpdatePresupuestoException;


use Illuminate\Support\Carbon;

class PresupuestoService
{
    public function __construct(
        private StorePresupuestoAction $storePresupuestoMesActualAction,
        private PresupuestoReadRepositoryContract $presupuestoReadRepository,
        private UpdatePresupuestoAction $updatePresupuestoAction,
        private DestroyPresupuestoAction $destroyPresupuestoAction,
        private CategoriaReadRepositoryContract $categoriaReadRepository,
        private PresupuestoQueryService $presupuestoQueryService
    ) {
    }

    private function storeValidate(StorePresupuestoMesActualDTO $dto): void
    {
        if ($this->presupuestoReadRepository->getEqualPresupuesto($dto->categoria_id, $dto->periodo)->exists()) {
            throw new CannotStorePresupuestoException(message: 'Ya existe un presupuesto para la fecha seleccionada');
        }
    }

    private function updateValidate(UpdatePresupuestoMesActualDTO $dto, Presupuesto $presupuesto): void
    {
        if ($this->presupuestoReadRepository->getEqualPresupuesto($dto->categoria_id, $dto->periodo)
            ->where('id', '!=', $presupuesto->id)
            ->exists()
        ) {
            throw new CannotUpdatePresupuestoException(message: 'Ya existe un presupuesto para la fecha seleccionada');
        }
    }

    private function canDuplicate(Presupuesto $presupuesto): bool{
       return $this->presupuestoQueryService->canDuplicate($presupuesto);
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

    public function duplicate(Presupuesto $presupuesto)
    {
        if (!$this->canDuplicate($presupuesto)) {
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
            $this->categoriaReadRepository->getAllByType(2)
        );
    }

    public function getRecordsCount(PresupuestoVariants $type): int
    {
        return $this->presupuestoQueryService->getRecordsCount($type);
    }

    public function getAllWithDetails(PresupuestoVariants $type): AnonymousResourceCollection
    {
        return $this->presupuestoQueryService->getAllWithDetails($type);
    }

    /**
     * Get paginated presupuestos (server-side)
     */
    public function getAllPaginated(PresupuestoVariants $variant = PresupuestoVariants::HISTORICO, array $data): AnonymousResourceCollection
    {
        $dto = TableQueryDTO::fromArray($data);
        return $this->presupuestoQueryService->getAllPaginated($variant, $dto);
    }

    /**
     * Get paginator metadata
     */
    public function getPaginatorMetaData()
    {
        return $this->presupuestoQueryService->getPaginator();
    }
}