<?php

namespace App\Domains\Categoria\Services;

use App\Models\Categoria\Categoria;
use App\Domains\Categoria\Actions\StoreCategoriaAction;
use App\Domains\Categoria\Actions\UpdateCategoriaAction;    
use App\Domains\Categoria\Actions\DestroyCategoriaAction;
use App\Domains\Categoria\Repositories\Contracts\CategoriaReadRepositoryContract;
use App\Domains\TipoMovimiento\Repositories\Contracts\TipoMovimientoReadRepositoryContract;
use App\Domains\Categoria\DTOs\CategoriaFormOptionsDTO;
use App\Domains\Categoria\DTOs\StoreAndUpdateCategoriaDTO;
use App\Domains\Categoria\Exceptions\CannotStoreCategoriaException;
use App\Domains\Categoria\Resources\CategoriaResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;


class CategoriaService{
    public function __construct(
        private StoreCategoriaAction $storeCategoriaAction,
        private UpdateCategoriaAction $updateCategoriaAction,
        private DestroyCategoriaAction $destroyCategoriaAction,
        private CategoriaReadRepositoryContract $categoriaReadRepository,
        private TipoMovimientoReadRepositoryContract $tipoMovimientoReadRepository)
    {
    }


    private function storeValidate(StoreAndUpdateCategoriaDTO $dto){
        if($this->categoriaReadRepository->getEqual($dto->nombre, $dto->tipo_movimiento_id)->exists()){
            throw new CannotStoreCategoriaException;
        }
    }
    public function store(array $data): Categoria{
        $dto = StoreAndUpdateCategoriaDTO::fromArray($data);
        $this->storeValidate($dto);
        return $this->storeCategoriaAction->store($dto);
    }

    public function update(Categoria $categoria, array $data): bool{
        $dto = StoreAndUpdateCategoriaDTO::fromArray($data);
        return $this->updateCategoriaAction->update($categoria, $dto);
    }

    public function destroy(Categoria $categoria): bool
    {
        return $this->destroyCategoriaAction->destroy($categoria);
    }

    public function toggleEsFijo(Categoria $categoria): bool
    {
        return $this->updateCategoriaAction->toggleEsFijo($categoria);
    }
    public function getOptions() : CategoriaFormOptionsDTO
    {
        return new CategoriaFormOptionsDTO(
            tipos: $this->tipoMovimientoReadRepository->getAll()
        );
    }

    public function getRecordsCount() : int{
        return $this->categoriaReadRepository->getRecordsCount();
    }

    public function getAllWithDetails() : AnonymousResourceCollection
    {
        $categorias = $this->categoriaReadRepository->getAllWithFullDetails();
        return CategoriaResource::collection($categorias);
    }
}